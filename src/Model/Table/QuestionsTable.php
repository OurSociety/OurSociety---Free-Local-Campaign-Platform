<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\Behavior;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Utility\Hash;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\Question;
use OurSociety\Model\Entity\User;
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
            // level
            ->allowEmpty('level')
            ->integer('level')
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

    protected function findBatch(Query $query, array $options): Query
    {
        $user = $options['user'] ?? null;

        if (!$user instanceof User) {
            throw new \InvalidArgumentException('User required');
        }

        $whereUserHasAnsweredThisQuestion = function (Query $query) use ($user) {
            return $query->where(['Answers.user_id' => $user->id]);
        };

        return $query
            ->notMatching('Answers', $whereUserHasAnsweredThisQuestion)
            ->where(['Questions.level' => $user->level])
            ->contain(['Categories' => ['fields' => ['slug', 'name']]])
            ->order(defined('SEED') ? sprintf('RAND(%s)', SEED) : 'RAND()');
    }

    public function getLevelQuestionTotal(User $user): int
    {
        return $this->find()->where(['Questions.level' => $user->level])->count();
    }
}
