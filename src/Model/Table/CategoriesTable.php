<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\Collection\Collection;
use Cake\Collection\CollectionInterface;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\EntityInterface as Entity;
use Cake\Datasource\ResultSetInterface as ResultSet;
use Cake\ORM\Association;
use Cake\ORM\Query;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\Category;
use OurSociety\Model\Entity\User;
use OurSociety\Validation\Validator as AppValidator;

/**
 * Categories Model
 *
 * @property QuestionsTable|Association\HasMany $Questions
 * @property ValueMatchesTable|Association\HasMany $ValueMatches
 * @property UsersTable|Association\BelongsToMany $Users
 *
 * @method Category get($primaryKey, $options = [])
 * @method Category newEntity($data = null, array $options = [])
 * @method Category[] newEntities(array $data, array $options = [])
 * @method Category|bool save(Entity $entity, $options = [])
 * @method Category patchEntity(Entity $entity, array $data, array $options = [])
 * @method Category[] patchEntities($entities, array $data, array $options = [])
 * @method Category findOrCreate($search, callable $callback = null, $options = [])
 */
class CategoriesTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->hasMany('Questions');
        $this->belongsToMany('Users');
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
            // question_count
            ->integer('question_count')
            ->notEmpty('question_count')
            ->requirePresence('question_count', 'create');
    }

    public function getMatchPercentages(User $citizen, User $politician, bool $inverse = false, ?int $limit = null): CollectionInterface
    {
        $this->hasOne('ValueMatch', [
            'className' => ValueMatchesTable::class,
            'conditions' => [
                'ValueMatch.citizen_id' => $citizen->id,
                'ValueMatch.politician_id' => $politician->id,
                'ValueMatch.category_id IS NOT' => null,
            ],
        ]);

        return $this->find()->contain(['ValueMatch'])->order([
            'ValueMatch.true_match_percentage' => $inverse === false ? 'DESC' : 'ASC',
        ])->limit($limit)->all();
    }
}
