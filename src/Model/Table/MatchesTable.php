<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\Match;
use OurSociety\Validation\Validator as AppValidator;

/**
 * Matches Model
 *
 * @property AnswersTable|Association\BelongsTo $Answers
 * @property |Association\BelongsTo $Users
 *
 * @method Match get($primaryKey, $options = [])
 * @method Match newEntity($data = null, array $options = [])
 * @method Match[] newEntities(array $data, array $options = [])
 * @method Match|bool save(Entity $entity, $options = [])
 * @method Match patchEntity(Entity $entity, array $data, array $options = [])
 * @method Match[] patchEntities($entities, array $data, array $options = [])
 * @method Match findOrCreate($search, callable $callback = null, $options = [])
 */
class MatchesTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('Answers');
        $this->belongsTo('Users');
    }

    /**
     * {@inheritdoc}
     */
    public function validationDefault(CakeValidator $validator): AppValidator
    {
        return parent::validationDefault($validator)
            // match
            ->notEmpty('match')
            ->requirePresence('match', 'create')
            ->scalar('match')
            // answer
            ->notEmpty('answer')
            ->requirePresence('answer', 'create')
            ->scalar('answer')
            // importance
            ->notEmpty('importance')
            ->requirePresence('importance', 'create')
            ->scalar('importance');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['answer_id'], 'Answers'))
            ->add($rules->existsIn(['user_id'], 'Users'));
    }
}
