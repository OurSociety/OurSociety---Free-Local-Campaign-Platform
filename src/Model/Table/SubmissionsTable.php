<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\Submission;
use OurSociety\Validation\Validator as AppValidator;

/**
 * Submissions Model
 *
 * @property UsersTable|Association\BelongsTo $Users
 *
 * @method Submission get($primaryKey, $options = [])
 * @method Submission newEntity($data = null, array $options = [])
 * @method Submission[] newEntities(array $data, array $options = [])
 * @method Submission|bool save(Entity $entity, $options = [])
 * @method Submission patchEntity(Entity $entity, array $data, array $options = [])
 * @method Submission[] patchEntities($entities, array $data, array $options = [])
 * @method Submission findOrCreate($search, callable $callback = null, $options = [])
 */
class SubmissionsTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('Users');
    }

    /**
     * {@inheritdoc}
     */
    public function validationDefault(CakeValidator $validator): AppValidator
    {
        return parent::validationDefault($validator)
            // body
            ->notEmpty('body')
            ->requirePresence('body', 'create')
            ->scalar('body')
            // done
            ->boolean('done')
            ->notEmpty('done');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['user_id'], 'Users'));
    }
}
