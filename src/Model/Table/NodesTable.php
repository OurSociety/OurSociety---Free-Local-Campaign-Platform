<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\Behavior;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\Node;
use OurSociety\Validation\Validator as AppValidator;

/**
 * Nodes Model
 *
 * @property NodesTable|Association\BelongsTo $ParentNodes
 * @property NodesTable|Association\HasMany $ChildNodes
 *
 * @method Node get($primaryKey, $options = [])
 * @method Node newEntity($data = null, array $options = [])
 * @method Node[] newEntities(array $data, array $options = [])
 * @method Node|bool save(Entity $entity, $options = [])
 * @method Node patchEntity(Entity $entity, array $data, array $options = [])
 * @method Node[] patchEntities($entities, array $data, array $options = [])
 * @method Node findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin Behavior\TreeBehavior
 */
class NodesTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->addBehavior('Tree');

        //$this->belongsTo('ParentNodes');
        //$this->hasMany('ChildNodes');
    }

    /**
     * {@inheritdoc}
     */
    public function validationDefault(CakeValidator $validator): AppValidator
    {
        return parent::validationDefault($validator)
            // table
            //->notEmpty('table')
            //->requirePresence('table', 'create')
            //->scalar('table')
            // foreign_key
            ->notEmpty('foreign_key')
            ->requirePresence('foreign_key', 'create')
            ->uuid('foreign_key');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules);
            //->add($rules->existsIn(['parent_id'], 'Nodes'));
    }
}
