<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\State;
use OurSociety\Validation\Validator as AppValidator;

/**
 * States Model
 *
 * @property ElectionAdministrationsTable|Association\BelongsTo $ElectionAdministrations
 * @property ElectionsTable|Association\HasMany $Elections
 * @property ElectoralDistrictsTable|Association\HasMany $ElectoralDistricts
 *
 * @method State get($primaryKey, $options = [])
 * @method State newEntity($data = null, array $options = [])
 * @method State[] newEntities(array $data, array $options = [])
 * @method State|bool save(Entity $entity, $options = [])
 * @method State patchEntity(Entity $entity, array $data, array $options = [])
 * @method State[] patchEntities($entities, array $data, array $options = [])
 * @method State findOrCreate($search, callable $callback = null, $options = [])
 */
class StatesTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('ElectionAdministrations');
        $this->hasMany('Elections');
        $this->hasMany('ElectoralDistricts');
    }

    /**
     * {@inheritdoc}
     */
    public function validationDefault(CakeValidator $validator): AppValidator
    {
        return parent::validationDefault($validator)
            // name
            ->notEmpty('name')
            ->requirePresence('name', 'create')
            ->scalar('name');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['election_administration_id'], 'ElectionAdministrations'));
    }
}
