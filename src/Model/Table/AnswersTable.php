<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\Behavior;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\Answer;
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
            ->notBlank('answer')
            ->requirePresence('answer', 'create');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['question_id'], 'Questions'))
            ->add($rules->existsIn(['user_id'], 'Users'));
    }
}
