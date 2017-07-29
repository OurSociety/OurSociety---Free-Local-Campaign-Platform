<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\Database\Connection;
use Cake\Datasource\EntityInterface as Entity;
use Cake\Event\Event;
use Cake\ORM\Association;
use Cake\ORM\Behavior;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\Answer;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Entity\ValueMatch;
use OurSociety\Validation\Validator as AppValidator;

/**
 * Answers Model
 *
 * @property QuestionsTable|Association\BelongsTo $Questions
 * @property UsersTable|Association\BelongsTo $Users
 *
 * @method Answer get($primaryKey, $options = [])
 * @method Answer newEntity($data = null, array $options = [])
 * @method Answer[] newEntities(array $data, array $options = [])
 * @method Answer|bool save(Entity $entity, $options = [])
 * @method Answer patchEntity(Entity $entity, array $data, array $options = [])
 * @method Answer[] patchEntities($entities, array $data, array $options = [])
 * @method Answer findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin Behavior\CounterCacheBehavior
 */
class AnswersTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setDisplayField('name');

        $this->addBehavior('CounterCache', [
            'Users' => ['answer_count'],
            // TODO: Implement scope for following counter-caches
            //'Questions' => ['citizen_answer_count', 'politician_answer_count'],
        ]);

        $this->belongsTo('Questions');
        $this->belongsTo('Users');
    }

    /**
     * {@inheritdoc}
     */
    public function validationDefault(CakeValidator $validator): AppValidator
    {
        return parent::validationDefault($validator)
            // question_id
            ->uuid('question_id')
            ->notEmpty('question_id')
            ->requirePresence('question_id', 'create')
            // user_id
            ->uuid('user_id')
            ->notEmpty('user_id')
            ->requirePresence('user_id', 'create')
            // answer
            ->integer('answer')
            ->notEmpty('answer', 'Please choose an answer for this question.')
            ->requirePresence('answer', 'create')
            // importance
            ->integer('importance')
            ->notEmpty('importance', 'Please specify if the topic of this question is important to you.')
            ->requirePresence('importance', 'create');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['question_id'], 'Questions', 'Sorry, we could not find that question.'))
            ->add($rules->existsIn(['user_id'], 'Users', 'Sorry, we could not find that user.'))
            ->add($rules->isUnique(['question_id', 'user_id'], 'Sorry, you have already answered this question.'));
    }

    public function afterSave(Event $event, Answer $answer, \ArrayObject $options)
    {
        /** @var User $userFrom */
        $userFrom = $answer->user;
        if ($userFrom === null) {
            $userFrom = $this->Users->get($answer->user_id);
        }

        $question = $answer->question;
        if ($question === null) {
            $question = $this->Questions->get($answer->question_id);
        }

        /** @var User[] $usersTo */
        $usersTo = $this->Users->find()->where([
            'answer_count >' => 0,
            'role' => $userFrom->isPolitician()
                ? User::ROLE_CITIZEN
                : User::ROLE_POLITICIAN,
        ])->all();

        $data = [];
        foreach ($usersTo as $userTo) {
            $dataDefault = [
                'citizen_id' => $userFrom->isPolitician() ? $userTo->id : $userFrom->id,
                'politician_id' => $userFrom->isPolitician() ? $userFrom->id : $userTo->id,
            ];
            $data[] = $dataDefault + [
                'category_id' => $question->category_id,
            ];
        }

        $conditions = ['or' => []];
        foreach ((array)$data as $condition) {
            if ($condition['category_id'] === null) {
                unset($condition['category_id']);
                $condition['category_id IS'] = null;
            }
            $conditions['or'][] = $condition;
        }
        /** @var ValueMatch[] $outdatedMatches */
        $outdatedMatches = $this->Users->ValueMatches->find()->where($conditions)->all();

        foreach ($outdatedMatches as $outdatedMatch) {
            foreach ($data as &$datum) {
                if (
                    $datum['citizen_id'] === $outdatedMatch->citizen_id &&
                    $datum['politician_id'] === $outdatedMatch->politician_id &&
                    $datum['category_id'] === $outdatedMatch->category_id
                ) {
                    $datum['id'] = $outdatedMatch->id;
                }
            }
            unset($datum);
        }

        foreach ($data as &$datum) {
            $citizenQuestionIds = $this->find()->where(['user_id' => $datum['citizen_id']])->all()->extract('question_id')->toArray();
            $politicianCommonQuestionCount = $this->find()->where([
                'user_id' => $datum['politician_id'],
                'question_id IN' => $citizenQuestionIds,
            ])->count();

            $sampleSize = $politicianCommonQuestionCount;
            if ($sampleSize === 0) {
                $errorPercentage = 1.0;
                $matchPercentage = 0.0;
                $trueMatchPercentage = 0.0;
            } else {
                $errorPercentage = (1 / $sampleSize) * 100;

                /** @var Connection $connection */
                $query = <<<SQL
   SELECT (SQRT(
              SUM(IFNULL((
                  LEAST(ABS(citizen.answer), ABS(politician.answer)) /
                  GREATEST(ABS(citizen.answer), ABS(politician.answer))
              ), 1) * citizen.importance) / SUM(citizen.importance) * 100
              *
              SUM(IFNULL((
                  LEAST(ABS(citizen.answer), ABS(politician.answer)) /
                  GREATEST(ABS(citizen.answer), ABS(politician.answer))
              ), 1) * politician.importance) / SUM(politician.importance) * 100
          )) AS match_percentage
     FROM answers as citizen
LEFT JOIN answers as politician
       ON politician.question_id = citizen.question_id
      AND politician.user_id = ?
    WHERE citizen.user_id = ?
 ORDER BY citizen.question_id
SQL;

                $connection = $this->getConnection();
                $statement = $connection->execute($query, [$datum['citizen_id'], $datum['politician_id']]);
                $matchPercentage = $statement->fetch('assoc')['match_percentage'];

                $trueMatchPercentage = max($matchPercentage - $errorPercentage, 0);
            }

            $datum += [
                'true_match_percentage' => $trueMatchPercentage,
                'match_percentage' => $matchPercentage,
                'error_percentage' => $errorPercentage,
                'sample_size' => $sampleSize,
            ];
        }
        unset($datum);

        $updatedMatches = $this->Users->ValueMatches->patchEntities($outdatedMatches, $data);

        $this->Users->ValueMatches->saveMany($updatedMatches);
    }
}
