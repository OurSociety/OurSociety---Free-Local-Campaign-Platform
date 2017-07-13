<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Answers Model
 *
 * @property \OurSociety\Model\Table\QuestionsTable|\Cake\ORM\Association\BelongsTo $Questions
 * @property \OurSociety\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \OurSociety\Model\Entity\Answer get($primaryKey, $options = [])
 * @method \OurSociety\Model\Entity\Answer newEntity($data = null, array $options = [])
 * @method \OurSociety\Model\Entity\Answer[] newEntities(array $data, array $options = [])
 * @method \OurSociety\Model\Entity\Answer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \OurSociety\Model\Entity\Answer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \OurSociety\Model\Entity\Answer[] patchEntities($entities, array $data, array $options = [])
 * @method \OurSociety\Model\Entity\Answer findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\CounterCacheBehavior
 */
class AnswersTable extends Table
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

        $this->setDisplayField('answer');

        $this->addBehavior('CounterCache', [
            'Users' => ['answer_count'],
            // TODO: Implement scope for following counter-caches
            //'Questions' => ['citizen_answer_count', 'politician_answer_count'],
        ]);

        $this->belongsTo('Questions');
        $this->belongsTo('Users');
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
            // answer
            ->requirePresence('answer', 'create')
            ->notEmpty('answer');
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
            ->add($rules->existsIn(['question_id'], 'Questions'))
            ->add($rules->existsIn(['user_id'], 'Users'));
    }
}
