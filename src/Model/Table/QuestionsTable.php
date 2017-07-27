<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\Behavior;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\ORM\Query;
use Cake\ORM\ResultSet;
use Cake\ORM\RulesChecker;
use Cake\Utility\Hash;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\Question;
use OurSociety\Validation\Validator as AppValidator;

/**
 * Questions Model
 *
 * @property CategoriesTable|Association\BelongsTo $Categories
 * @property AnswersTable|Association\HasMany $Answers
 *
 * @method Question get($primaryKey, $options = [])
 * @method Question newEntity($data = null, array $options = [])
 * @method Question[] newEntities(array $data, array $options = [])
 * @method Question|bool save(Entity $entity, $options = [])
 * @method Question patchEntity(Entity $entity, array $data, array $options = [])
 * @method Question[] patchEntities($entities, array $data, array $options = [])
 * @method Question findOrCreate($search, callable $callback = null, $options = [])
 * @method static QuestionsTable instance(?string $alias = null, ?array $options = [])
 *
 * @mixin Behavior\CounterCacheBehavior
 */
class QuestionsTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setDisplayField('question');

        $this->addBehavior('CounterCache', ['Categories' => ['question_count']]);

        $this->belongsTo('Categories');
        $this->hasMany('Answers');
        //$this->belongsToMany('Users', ['through' => 'Answers']);
    }

    /**
     * {@inheritdoc}
     */
    public function validationDefault(CakeValidator $validator): AppValidator
    {
        return parent::validationDefault($validator)
            // question
            ->notEmpty('question')
            ->requirePresence('question', 'create')
            // type
            ->notEmpty('type')
            ->requirePresence('type', 'create')
            // citizen_answer_count
            ->integer('citizen_answer_count')
            ->notEmpty('citizen_answer_count')
            ->requirePresence('citizen_answer_count', 'create')
            // politician_answer_count
            ->integer('politician_answer_count')
            ->notEmpty('politician_answer_count')
            ->requirePresence('politician_answer_count', 'create');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['category_id'], 'Categories'));
    }

    /**
     * @param Query|null $query
     * @return ResultSet|Question[]
     */
    public function getBatch(?Query $query = null): ResultSet
    {
        $query = $query ?: $this->find();
        $order = defined('SEED') ? sprintf('RAND(%s)', SEED) : 'RAND()';

        return $query->contain(['Categories' => ['fields' => ['slug', 'name']]])->order($order)->limit(10)->all();
    }

    public function saveAnswers(array $formData): void
    {
        $data = collection($formData)->filter(function ($question) {
            return !empty($question['answers'][0]['answer']);
        })->toArray();
        $ids = Hash::extract($formData, '{n}.id');
        $questions = $this->find()->where(['id IN' => $ids])->all();
        $questions = $this->patchEntities($questions, $data, ['validate' => false, 'associated' => ['Answers']]);
        $this->getConnection()->transactional(function () use ($questions) {
            foreach ($questions as $question) {
                /** @var Question $question */
                $question = $this->saveOrFail($question, ['atomic' => false]);
                if (count($question->answers) === 0) {
                    throw new PersistenceFailedException($question, 'Answer was not saved');
                }
            }
        });
    }

    public function getQuestionTotal(): int
    {
        return $this->find()->count();
    }
}
