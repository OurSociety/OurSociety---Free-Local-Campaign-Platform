<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\Report;
use OurSociety\ORM\TableRegistry;
use OurSociety\Validation\Validator as AppValidator;

/**
 * Reports Model
 *
 * @property QuestionsTable|Association\BelongsTo $Questions
 * @property UsersTable|Association\BelongsTo $Users
 *
 * @method Report get($primaryKey, $options = [])
 * @method Report newEntity($data = null, array $options = [])
 * @method Report[] newEntities(array $data, array $options = [])
 * @method Report|bool save(Entity $entity, $options = [])
 * @method Report patchEntity(Entity $entity, array $data, array $options = [])
 * @method Report[] patchEntities($entities, array $data, array $options = [])
 * @method Report findOrCreate($search, callable $callback = null, $options = [])
 */
class ReportsTable extends AppTable
{
    public static function instance(array $options = null): self
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return TableRegistry::get('Reports', $options ?? []);
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('Questions');
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
            //->boolean('done') // TODO: Determine why Validation::boolean gets wrong $booleanValues argument
            ->notEmpty('done');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['question_id'], 'Questions'))
            ->add($rules->existsIn(['user_id'], 'Users'));
    }
}
