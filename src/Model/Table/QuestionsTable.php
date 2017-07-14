<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Behavior\CounterCacheBehavior;
use Cake\ORM\ResultSet;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use OurSociety\Model\Entity\Question;

/**
 * Questions Model
 *
 * @property CategoriesTable|BelongsTo $Categories
 * @property UsersTable|BelongsToMany $Users
 *
 * @method Question get($primaryKey, $options = [])
 * @method Question newEntity($data = null, array $options = [])
 * @method Question[] newEntities(array $data, array $options = [])
 * @method Question|bool save(Entity $entity, $options = [])
 * @method Question patchEntity(Entity $entity, array $data, array $options = [])
 * @method Question[] patchEntities($entities, array $data, array $options = [])
 * @method Question findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin CounterCacheBehavior
 */
class QuestionsTable extends AppTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setDisplayField('question');

        $this->addBehavior('CounterCache', ['Categories' => ['question_count']]);

        $this->belongsTo('Categories');
        $this->belongsToMany('Users');
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        return parent::validationDefault($validator)
            // question
            ->requirePresence('question', 'create')
            ->notEmpty('question')
            // type
            ->requirePresence('type', 'create')
            ->notEmpty('type')
            // citizen answer count
            ->integer('citizen_answer_count')
            ->requirePresence('citizen_answer_count', 'create')
            ->notEmpty('citizen_answer_count')
            // politician answer count
            ->integer('politician_answer_count')
            ->requirePresence('politician_answer_count', 'create')
            ->notEmpty('politician_answer_count');
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['category_id'], 'Categories'));
    }

    public function findBatch(): ResultSet
    {
        $order = defined('SEED') ? sprintf('RAND(%s)', SEED) : 'RAND()';

        return $this->find()->order($order)->limit(10)->all();
    }
}
