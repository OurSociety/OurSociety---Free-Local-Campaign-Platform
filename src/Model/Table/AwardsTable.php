<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

use Cake\Database\Schema\TableSchema;
use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Database\Type\MonthType;
use OurSociety\Model\Entity\Award;
use OurSociety\Validation\Validator as AppValidator;

/**
 * Awards table.
 *
 * @property UsersTable|Association\BelongsTo $Politicians
 *
 * @method Award get($primaryKey, $options = [])
 * @method Award newEntity($data = null, array $options = [])
 * @method Award[] newEntities(array $data, array $options = [])
 * @method Award|bool save(Entity $entity, $options = [])
 * @method Award patchEntity(Entity $entity, array $data, array $options = [])
 * @method Award[] patchEntities($entities, array $data, array $options = [])
 * @method Award findOrCreate($search, callable $callback = null, $options = [])
 */
class AwardsTable extends AppTable
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
            // description
            ->notEmpty('politician_id')
            ->requirePresence('politician_id', 'create')
            // description
            ->notEmpty('description')
            ->requirePresence('description', 'create')
            // obtained
            ->yearMonth('obtained')
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

    protected function _initializeSchema(TableSchema $schema): TableSchema
    {
        $schema->setColumnType('obtained', MonthType::TYPE_NAME);

        return $schema;
    }
}
