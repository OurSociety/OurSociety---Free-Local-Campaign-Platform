<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

use Cake\Database\Schema\TableSchema;
use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Database\Type\MonthType;
use OurSociety\Model\Entity\Qualification;
use OurSociety\Validation\Validator as AppValidator;

/**
 * Qualifications table.
 *
 * @property UsersTable|Association\BelongsTo $Politicians
 *
 * @method Qualification get($primaryKey, $options = [])
 * @method Qualification newEntity($data = null, array $options = [])
 * @method Qualification[] newEntities(array $data, array $options = [])
 * @method Qualification|bool save(Entity $entity, $options = [])
 * @method Qualification patchEntity(Entity $entity, array $data, array $options = [])
 * @method Qualification[] patchEntities($entities, array $data, array $options = [])
 * @method Qualification findOrCreate($search, callable $callback = null, $options = [])
 */
class QualificationsTable extends AppTable
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
            // institution
            ->notEmpty('institution')
            ->requirePresence('institution', 'create')
            // started
            ->yearMonth('started')
            ->notEmpty('started')
            ->requirePresence('started', 'create')
            // ended
            ->allowEmpty('ended')
            ->yearMonth('ended')
            ->requirePresence('ended', 'create');
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
