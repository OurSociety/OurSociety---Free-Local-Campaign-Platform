<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use OurSociety\Model\Entity\PoliticianAward;

/**
 * PoliticianAwards Model
 *
 * @property PoliticiansTable|Association\BelongsTo $Politicians
 *
 * @method PoliticianAward get($primaryKey, $options = [])
 * @method PoliticianAward newEntity($data = null, array $options = [])
 * @method PoliticianAward[] newEntities(array $data, array $options = [])
 * @method PoliticianAward|bool save(Entity $entity, $options = [])
 * @method PoliticianAward patchEntity(Entity $entity, array $data, array $options = [])
 * @method PoliticianAward[] patchEntities($entities, array $data, array $options = [])
 * @method PoliticianAward findOrCreate($search, callable $callback = null, $options = [])
 */
class PoliticianAwardsTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('Politicians', ['className' => UsersTable::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function validationDefault(Validator $validator): Validator
    {
        return parent::validationDefault($validator)
            // name
            ->notEmpty('name')
            ->requirePresence('name', 'create')
            // description
            ->notEmpty('description')
            ->requirePresence('description', 'create')
            // obtained
            ->date('obtained')
            ->notEmpty('obtained')
            ->requirePresence('obtained', 'create');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['politician_id'], 'Politicians'));
    }
}
