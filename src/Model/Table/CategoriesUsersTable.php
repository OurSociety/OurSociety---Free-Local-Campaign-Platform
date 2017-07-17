<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use OurSociety\Model\Entity\CategoriesUser;

/**
 * CategoriesUsers Model
 *
 * @property CategoriesTable|Association\BelongsTo $Categories
 * @property UsersTable|Association\BelongsTo $Users
 *
 * @method CategoriesUser get($primaryKey, $options = [])
 * @method CategoriesUser newEntity($data = null, array $options = [])
 * @method CategoriesUser[] newEntities(array $data, array $options = [])
 * @method CategoriesUser|bool save(Entity $entity, $options = [])
 * @method CategoriesUser patchEntity(Entity $entity, array $data, array $options = [])
 * @method CategoriesUser[] patchEntities($entities, array $data, array $options = [])
 * @method CategoriesUser findOrCreate($search, callable $callback = null, $options = [])
 */
class CategoriesUsersTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('Categories');
        $this->belongsTo('Users');
    }

    /**
     * {@inheritdoc}
     */
    public function validationDefault(Validator $validator): Validator
    {
        return parent::validationDefault($validator)
            // answer_count
            ->integer('answer_count')
            ->notEmpty('answer_count')
            ->requirePresence('answer_count', 'create');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['category_id'], 'Categories'))
            ->add($rules->existsIn(['user_id'], 'Users'));
    }
}
