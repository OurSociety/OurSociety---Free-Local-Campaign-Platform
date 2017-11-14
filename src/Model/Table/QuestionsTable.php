<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\Behavior;
use Cake\ORM\ResultSet;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Behavior\CounterCacheBehavior;
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
 * @method Question[]|ResultSet findByLevel($level)
 *
 * @mixin Behavior\CounterCacheBehavior
 */
class QuestionsTable extends AppTable
{
    public const LIMIT_BATCH = 10;

    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setDisplayField('question');

        $this->addBehavior(CounterCacheBehavior::class, [
            'Categories' => ['question_count'],
        ]);

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
}
