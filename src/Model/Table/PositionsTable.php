<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

use Cake\Database\Schema\TableSchema;
use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Database\Type\MonthType;
use OurSociety\Model\Entity\Position;
use OurSociety\Validation\Validator as AppValidator;

/**
 * Positions table.
 *
 * @property UsersTable|Association\BelongsTo $Politicians
 *
 * @method Position get($primaryKey, $options = [])
 * @method Position newEntity($data = null, array $options = [])
 * @method Position[] newEntities(array $data, array $options = [])
 * @method Position|bool save(Entity $entity, $options = [])
 * @method Position patchEntity(Entity $entity, array $data, array $options = [])
 * @method Position[] patchEntities($entities, array $data, array $options = [])
 * @method Position findOrCreate($search, callable $callback = null, $options = [])
 */
class PositionsTable extends AppTable
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
    public function validationDefault(CakeValidator $validator): AppValidator
    {
        return parent::validationDefault($validator)
            // name
            ->notEmpty('name')
            ->requirePresence('name', 'create')
            // company
            ->notEmpty('company')
            ->requirePresence('company', 'create')
            // started
            ->yearMonth('started')
            ->notEmpty('started')
            ->requirePresence('started', 'create')
            // ended
            ->allowEmpty('ended')
            ->yearMonth('ended');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['politician_id'], 'Politicians'));
    }

    protected function _initializeSchema(TableSchema $schema): TableSchema
    {
        $schema->setColumnType('started', MonthType::TYPE_NAME);
        $schema->setColumnType('ended', MonthType::TYPE_NAME);

        return $schema;
    }
}
