<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface as Entity;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Association;
use Cake\ORM\RulesChecker;
use Cake\Routing\Router;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Behavior\CounterCacheBehavior;
use OurSociety\Model\Entity\Article;
use OurSociety\Model\Entity\ElectoralDistrict;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Users;
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
        $this->belongsTo('ElectoralDistricts')->setFinder('isMunicipality')->setStrategy('select');
        $this->belongsTo('Politicians', ['className' => UsersTable::class]);

        $this->addBehavior(CounterCacheBehavior::class, [
            'ElectoralDistricts' => [
                'article_factcheck_count' => ['finder' => 'isNotApproved'],
                'article_year_count' => ['finder' => 'wasApprovedThisYear'],
            ],
        ]);
    }

    /**
     * After save callback.
     *
     * @param Event $event
     * @param Entity|Article $entity
     * @param ArrayObject $options
     * @return void
     */
    public function afterSave(Event $event, Entity $entity, $options): void
    {
        if ($entity->isNew()) {
            $this->notifyUserAndAdmins($entity);
        }
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
            ->add($rules->existsIn(['politician_id'], 'Politicians'))
            ->add($rules->existsIn(['electoral_district_id'], 'ElectoralDistricts'));
    }

    public function getBySlug(string $slug, User $identity = null): Entity
    {
        return $this
            ->find('forCitizen', ['identity' => $identity])
            ->find('slugged', ['slug' => $slug])
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

    private function notifyUserAndAdmins(Article $article): void
    {
        $users = Users::instance();

        /** @var User $user */
        $user = $users->getByUniqueIdentifier($article->politician->slug, ['Users.id', 'Users.email', 'Users.name', 'Users.role']);
        if ($user->isAdmin()) {
            return;
        }

        /** @var ElectoralDistrict $municipality */
        $municipality = $this->ElectoralDistricts->find()->select(['ElectoralDistricts.slug'])->where([
            'ElectoralDistricts.id' => $article->electoral_district_id,
        ])->firstOrFail();

        $url = [
            '_name' => 'municipality:article',
            'municipality' => $municipality->slug,
            'article' => $article->slug,
        ];

        $body = <<<HTML
Hi {userName},

Thanks for your submission. We will notify you when fact-checking is complete.

{articleLink}

Thanks,

OurSociety Team.
HTML;

        $users->notifyUser(
            $user,
            __('Article "{name}" undergoing fact-checking.', ['name' => $article->name]),
            __($body, ['userName' => $user->name, 'articleLink' => Router::reverse($url, true)])
        );

        foreach ($users->getAdminUsers() as $admin) {
            $users->notifyUser(
                $admin,
                __('Article "{name}" requires fact-checking.', ['name' => $article->name]),
                __($body, ['userName' => $admin->name, 'articleLink' => Router::reverse($url, true)])
            );
        }
    }
}
