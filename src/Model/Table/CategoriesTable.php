<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Categories Model
 *
 * @property \OurSociety\Model\Table\QuestionsTable|\Cake\ORM\Association\HasMany $Questions
 * @property \OurSociety\Model\Table\UsersTable|\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \OurSociety\Model\Entity\Category get($primaryKey, $options = [])
 * @method \OurSociety\Model\Entity\Category newEntity($data = null, array $options = [])
 * @method \OurSociety\Model\Entity\Category[] newEntities(array $data, array $options = [])
 * @method \OurSociety\Model\Entity\Category|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \OurSociety\Model\Entity\Category patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \OurSociety\Model\Entity\Category[] patchEntities($entities, array $data, array $options = [])
 * @method \OurSociety\Model\Entity\Category findOrCreate($search, callable $callback = null, $options = [])
 */
class CategoriesTable extends Table
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

        $this->hasMany('Questions');
        $this->belongsToMany('Users');
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
            // name
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            // question_count
            ->integer('question_count')
            ->requirePresence('question_count', 'create')
            ->notEmpty('question_count');
    }
}
