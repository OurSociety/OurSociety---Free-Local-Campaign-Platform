<?php
namespace OurSociety\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CategoriesUsers Model
 *
 * @property \OurSociety\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 * @property \OurSociety\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \OurSociety\Model\Entity\CategoriesUser get($primaryKey, $options = [])
 * @method \OurSociety\Model\Entity\CategoriesUser newEntity($data = null, array $options = [])
 * @method \OurSociety\Model\Entity\CategoriesUser[] newEntities(array $data, array $options = [])
 * @method \OurSociety\Model\Entity\CategoriesUser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \OurSociety\Model\Entity\CategoriesUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \OurSociety\Model\Entity\CategoriesUser[] patchEntities($entities, array $data, array $options = [])
 * @method \OurSociety\Model\Entity\CategoriesUser findOrCreate($search, callable $callback = null, $options = [])
 */
class CategoriesUsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('Categories');
        $this->belongsTo('Users');
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        return parent::validationDefault($validator)
            // answer_count
            ->integer('answer_count')
            ->requirePresence('answer_count', 'create')
            ->notEmpty('answer_count');
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['category_id'], 'Categories'))
            ->add($rules->existsIn(['user_id'], 'Users'));
    }
}
