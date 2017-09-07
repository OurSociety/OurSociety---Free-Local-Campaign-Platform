<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface as Entity;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Association;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\PoliticianArticle;
use OurSociety\Model\Entity\User;
use OurSociety\Validation\Validator as AppValidator;

/**
 * PoliticianArticles Model
 *
 * @property ElectoralDistrictsTable|Association\BelongsTo $Municipalities
 * @property UsersTable|Association\BelongsTo $Politicians
 *
 * @method PoliticianArticle get($primaryKey, $options = [])
 * @method PoliticianArticle newEntity($data = null, array $options = [])
 * @method PoliticianArticle[] newEntities(array $data, array $options = [])
 * @method PoliticianArticle|bool save(Entity $entity, $options = [])
 * @method PoliticianArticle patchEntity(Entity $entity, array $data, array $options = [])
 * @method PoliticianArticle[] patchEntities($entities, array $data, array $options = [])
 * @method PoliticianArticle findOrCreate($search, callable $callback = null, $options = [])
 */
class PoliticianArticlesTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        $this->setTable('articles');

        parent::initialize($config);

        $this->belongsTo('Aspects', ['className' => CategoriesTable::class]);
        $this->belongsTo('Municipalities', ['className' => ElectoralDistrictsTable::class]);
        $this->belongsTo('ArticleTypes');
        $this->belongsTo('Politicians', ['className' => UsersTable::class]);
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

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['politician_id'], 'Politicians'));
    }

    public function getBySlug(string $slug, string $role = null): PoliticianArticle
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->find('forCitizen', ['role' => $role ?? User::ROLE_CITIZEN])
            ->where(['slug' => $slug])
            ->firstOrFail();
    }

    protected function findApproved(Query $query): Query
    {
        return $query->where([array_values($query->aliasField('approved'))[0] . ' IS NOT' => null]);
    }

    protected function findLatest(Query $query): Query
    {
        return $query->innerJoin(
            [
                'LatestPoliticianArticles' => $this->find()->select([
                    'LatestPoliticianArticles__slug' => 'slug',
                    'LatestPoliticianArticles__version' => $query->func()->max('version')
                ])->group('slug')
            ],
            [
                array_values($query->aliasField('slug'))[0] . ' = LatestPoliticianArticles__slug',
                array_values($query->aliasField('version'))[0] . ' = LatestPoliticianArticles__version',
            ]
        );
    }

    protected function findPublished(Query $query): Query
    {
        return $query->where([array_values($query->aliasField('published'))[0] . ' IS NOT' => null]);
    }

    protected function findForCitizen(Query $query, array $options = null): Query
    {
        $options += ['role' => User::ROLE_CITIZEN];

        if ($options['role'] === User::ROLE_CITIZEN) {
            $query->find('approved')->find('published');
        }

        return $query->find('latest');
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
}
