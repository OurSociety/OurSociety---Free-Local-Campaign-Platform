<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\CandidatePostElectionStatus;
use OurSociety\Validation\Validator as AppValidator;

/**
 * CandidatePostElectionStatuses Model
 *
 * @method CandidatePostElectionStatus get($primaryKey, $options = [])
 * @method CandidatePostElectionStatus newEntity($data = null, array $options = [])
 * @method CandidatePostElectionStatus[] newEntities(array $data, array $options = [])
 * @method CandidatePostElectionStatus|bool save(Entity $entity, $options = [])
 * @method CandidatePostElectionStatus patchEntity(Entity $entity, array $data, array $options = [])
 * @method CandidatePostElectionStatus[] patchEntities($entities, array $data, array $options = [])
 * @method CandidatePostElectionStatus findOrCreate($search, callable $callback = null, $options = [])
 */
class CandidatePostElectionStatusesTable extends AppTable
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
