<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface as Entity;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Association;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Behavior\CounterCacheBehavior;
use OurSociety\Model\Entity\Article;
use OurSociety\Model\Entity\User;
use OurSociety\Validation\Validator as AppValidator;

/**
 * Articles Model
 *
 * @property ElectoralDistrictsTable|Association\BelongsTo $ElectoralDistricts
 * @property UsersTable|Association\BelongsTo $Politicians
 *
 * @method Article get($primaryKey, $options = [])
 * @method Article newEntity($data = null, array $options = [])
 * @method Article[] newEntities(array $data, array $options = [])
 * @method Article|bool save(Entity $entity, $options = [])
 * @method Article patchEntity(Entity $entity, array $data, array $options = [])
 * @method Article[] patchEntities($entities, array $data, array $options = [])
 * @method Article findOrCreate($search, callable $callback = null, $options = [])
 */
class ArticlesTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('Aspects', ['className' => CategoriesTable::class]);
        $this->belongsTo('ArticleTypes');
        $this->belongsTo('ElectoralDistricts')->setFinder('municipality')->setStrategy('select');
        $this->belongsTo('Politicians', ['className' => UsersTable::class]);

        $this->addBehavior(CounterCacheBehavior::class, [
            'ElectoralDistricts' => [
                'article_factcheck_count' => ['finder' => 'isNotApproved'],
                'article_year_count' => ['finder' => 'wasApprovedThisYear'],
            ]
        ]);
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options): void
    {
        foreach (['published', 'approved'] as $field) {
            if (isset($data[$field])) {
                $data[$field] = (bool)$data[$field] ? Time::now() : null;
            }
        }

        parent::beforeMarshal($event, $data, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['politician_id'], 'Politicians'));
    }

    public function getBySlug(string $slug, string $role = null): Article
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->find('forCitizen', ['role' => $role ?? User::ROLE_CITIZEN])
            ->where(['slug' => $slug])
            ->firstOrFail();
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
            // body
            ->notEmpty('body')
            ->requirePresence('body', 'create')
            // version
            ->integer('version')
            ->notEmpty('version')
            // approved
            ->allowEmpty('approved')
            ->dateTime('approved')
            // published
            ->allowEmpty('published')
            ->dateTime('published');
    }
}
