<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\PoliticianArticle;
use OurSociety\Validation\Validator as AppValidator;

/**
 * PoliticianArticles Model
 *
 * @property PoliticiansTable|Association\BelongsTo $Politicians
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
        parent::initialize($config);

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
            ->requirePresence('version', 'create')
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

    protected function findApproved(Query $query): Query
    {
        return $query->where(['PoliticianArticles.approved IS NOT' => null]);
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
                'PoliticianArticles.slug = LatestPoliticianArticles__slug',
                'PoliticianArticles.version = LatestPoliticianArticles__version',
            ]
        );
    }

    protected function findPublished(Query $query): Query
    {
        return $query->where(['PoliticianArticles.published IS NOT' => null]);
    }

    protected function findForCitizen(Query $query): Query
    {
        return $query
            ->find('approved')
            ->find('published')
            ->find('latest');
    }
}
