<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\CandidatePreElectionStatus;
use OurSociety\Validation\Validator as AppValidator;

/**
 * CandidatePreElectionStatuses Model
 *
 * @method CandidatePreElectionStatus get($primaryKey, $options = [])
 * @method CandidatePreElectionStatus newEntity($data = null, array $options = [])
 * @method CandidatePreElectionStatus[] newEntities(array $data, array $options = [])
 * @method CandidatePreElectionStatus|bool save(Entity $entity, $options = [])
 * @method CandidatePreElectionStatus patchEntity(Entity $entity, array $data, array $options = [])
 * @method CandidatePreElectionStatus[] patchEntities($entities, array $data, array $options = [])
 * @method CandidatePreElectionStatus findOrCreate($search, callable $callback = null, $options = [])
 */
class CandidatePreElectionStatusesTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function validationDefault(CakeValidator $validator): AppValidator
    {
        return parent::validationDefault($validator)
            // name
            ->notEmpty('name')
            ->requirePresence('name', 'create')
            ->scalar('name')
            // id_vip
            ->notEmpty('id_vip')
            ->requirePresence('id_vip', 'create')
            ->scalar('id_vip')
            // description
            ->allowEmpty('description')
            ->scalar('description');
    }
}
