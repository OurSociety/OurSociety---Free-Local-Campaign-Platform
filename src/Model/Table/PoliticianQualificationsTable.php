<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use OurSociety\Model\Entity\PoliticianQualification;

/**
 * PoliticianQualifications Model
 *
 * @property PoliticiansTable|Association\BelongsTo $Politicians
 *
 * @method PoliticianQualification get($primaryKey, $options = [])
 * @method PoliticianQualification newEntity($data = null, array $options = [])
 * @method PoliticianQualification[] newEntities(array $data, array $options = [])
 * @method PoliticianQualification|bool save(Entity $entity, $options = [])
 * @method PoliticianQualification patchEntity(Entity $entity, array $data, array $options = [])
 * @method PoliticianQualification[] patchEntities($entities, array $data, array $options = [])
 * @method PoliticianQualification findOrCreate($search, callable $callback = null, $options = [])
 */
class PoliticianQualificationsTable extends AppTable
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
            // institution
            ->notEmpty('institution')
            ->requirePresence('institution', 'create')
            // started
            ->date('started')
            ->notEmpty('started')
            ->requirePresence('started', 'create')
            // ended
            ->allowEmpty('ended')
            ->date('ended')
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
}
