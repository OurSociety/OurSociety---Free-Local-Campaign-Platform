<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\Localized\Validation\UsValidation;
use Cake\ORM\Association;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation as Cake;
use OurSociety\Model\Entity\User;
use OurSociety\Validation\Validator as AppValidator;

/**
 * Users Model
 *
 * @property AnswersTable|Association\HasMany $Answers
 * @property CategoriesTable|Association\BelongsToMany $Categories
 *
 * @method User get($primaryKey, $options = [])
 * @method User newEntity($data = null, array $options = [])
 * @method User[] newEntities(array $data, array $options = [])
 * @method User|bool save(Entity $entity, $options = [])
 * @method User patchEntity(Entity $entity, array $data, array $options = [])
 * @method User[] patchEntities($entities, array $data, array $options = [])
 * @method User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends AppTable
{
    public const LIMIT_DASHBOARD = 10;
    public const ERROR_ROLE_NOT_IN_LIST = 'The only valid roles are "{0}".';
    public const ERROR_EMAIL_UNIQUE = 'This email address is already in use.';

    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->hasMany('Answers');
        $this->belongsToMany('Categories');

        //$this->addBehavior('CakeDC/Enum.Enum', ['lists' => ['role' => ['strategy' => 'const', 'prefix' => 'ROLE']]]);
    }

    /**
     * {@inheritdoc}
     *
     * @see \Cake\ORM\Table::validateUnique
     */
    public function validationDefault(Cake\Validator $validator): AppValidator
    {
        return parent::validationDefault($validator)
            ->setProvider('default', new Cake\Validation) // TODO: Find out why our validation class breaks email validation.
            // email
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => __(self::ERROR_EMAIL_UNIQUE)])
            //->email('email', false, 'Please enter a valid email address')
            ->notBlank('email')
            ->requirePresence('email', 'create')
            // zip
            ->setProvider('us', UsValidation::class)
            ->add('zip', 'zip', ['rule' => 'postal', 'provider' => 'us', 'message' => 'Please enter a valid ZIP code (e.g. 12345 or 12345-6789)'])
            // password
            ->notEmpty('password')
            ->requirePresence('password', 'create')
            // name
            ->notBlank('name')
            ->requirePresence('name', 'create')
            // token
            ->allowEmpty('token')
            // token_expires
            ->allowEmpty('token_expires')
            ->dateTime('token_expires')
            // active
            ->allowEmpty('active')
            ->dateTime('active')
            // role
            ->inList('role', User::ROLES, __(self::ERROR_ROLE_NOT_IN_LIST, implode('", "', User::ROLES)))
            ->notBlank('role')
            //->requirePresence('role', 'create') // TODO: Breaks registration
            // answer_count
            ->integer('answer_count')
            ->notEmpty('answer_count')
            //->requirePresence('answer_count', 'create') // TODO: Breaks registration
            // born
            ->allowEmpty('born')
            //->date('born') // TODO: Broken since validation changes.
            // last_seen
            ->allowEmpty('last_seen')
            ->dateTime('last_seen');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->isUnique(['email'], __(self::ERROR_EMAIL_UNIQUE)));
    }

    public function getListGroupedByRole(): Query
    {
        return $this
            ->find('list', ['keyField' => 'slug', 'groupField' => 'role'])
            ->order(['Users.role' => 'ASC', 'Users.name' => 'ASC']);
    }

    /**
     * Find for auth.
     *
     * Used by the AuthComponent to get all the authenticated user's data.
     *
     * TODO: Return associated information as it becomes known, or remove method if never used.
     *
     * @param Query $query The original query.
     * @return Query The updated query.
     */
    protected function findAuth(Query $query): Query
    {
        return $query;
    }

    protected function findHasAnsweredQuestions(Query $query): Query
    {
        return $query->where(['answer_count' > 0]);
    }

    protected function findIsActive(Query $query): Query
    {
        return $query->where(['active IS NOT' => null]);
    }

    protected function findIsPolitician(Query $query): Query
    {
        return $query->where(['role' => User::ROLE_POLITICIAN]);
    }

    protected function findPolitician(Query $query): Query
    {
        $this->hasMany('Articles', [
            'className' => PoliticianArticlesTable::class,
            'foreignKey' => 'politician_id'
        ]);
        $this->hasMany('Awards', [
            'className' => PoliticianAwardsTable::class,
            'foreignKey' => 'politician_id'
        ]);
        $this->hasMany('Positions', [
            'className' => PoliticianPositionsTable::class,
            'foreignKey' => 'politician_id'
        ]);
        $this->hasMany('Qualifications', [
            'className' => PoliticianQualificationsTable::class,
            'foreignKey' => 'politician_id'
        ]);
        $this->hasMany('Videos', [
            'className' => PoliticianVideosTable::class,
            'foreignKey' => 'politician_id',
            'conditions' => ['featured' => false] // TODO: Move to finder
        ]);
        $this->hasOne('FeaturedVideos', [
            'className' => PoliticianVideosTable::class,
            'foreignKey' => 'politician_id',
            'conditions' => ['featured' => true] // TODO: Move to finder
        ]);

        return $query->find('isPolitician')
            ->contain(['Articles', 'Awards', 'Positions', 'Qualifications', 'Videos', 'FeaturedVideos']);
    }

    protected function findPoliticianForCitizen(Query $query): Query
    {
        return $query->find('politician', ['role' => 'citizen'])->find('isActive')->find('hasAnsweredQuestions');
    }

    /**
     * Find recently created.
     *
     * Finds the recent created users by their registration date.
     *
     * @param Query $query The original query.
     * @return Query The updated query.
     */
    protected function findRecentlyCreated(Query $query): Query
    {
        return $query->orderDesc('created')->limit(self::LIMIT_DASHBOARD);
    }

    /**
     * Find recently active.
     *
     * Finds the recently active users by their last seen date.
     *
     * @param Query $query The original query.
     * @return Query The updated query.
     */
    protected function findRecentlyActive(Query $query): Query
    {
        return $query->orderDesc('last_seen')->limit(self::LIMIT_DASHBOARD);
    }

    public function getMatchPercentage(User $citizenUser, User $politicianUser)
    {
        return 100; // TODO: Calculate real match.
    }
}
