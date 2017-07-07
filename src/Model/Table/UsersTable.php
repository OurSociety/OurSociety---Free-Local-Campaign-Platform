<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use OurSociety\Model\Entity\User;

/**
 * Users Model
 *
 * @method User get($primaryKey, $options = [])
 * @method User newEntity($data = null, array $options = [])
 * @method User[] newEntities(array $data, array $options = [])
 * @method User|bool save(EntityInterface $entity, $options = [])
 * @method User patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method User[] patchEntities($entities, array $data, array $options = [])
 * @method User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends AppTable
{
    public const ROLES = [self::ROLE_ADMIN, self::ROLE_CITIZEN, self::ROLE_POLITICIAN];
    public const ROLE_ADMIN = 'admin';
    public const ROLE_CITIZEN = 'citizen';
    public const ROLE_POLITICIAN = 'politician';
    public const LIMIT_DASHBOARD = 10;
    public const ERROR_ROLE_NOT_IN_LIST = 'The only valid roles are "{0}".';
    public const ERROR_EMAIL_UNIQUE = 'This email address is already in use.';

    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        //$this->addBehavior('CakeDC/Enum.Enum', ['lists' => ['role' => ['strategy' => 'const', 'prefix' => 'ROLE']]]);
    }

    /**
     * {@inheritdoc}
     *
     * @see \Cake\ORM\Table::validateUnique
     */
    public function validationDefault(Validator $validator): Validator
    {
        return parent::validationDefault($validator)
            ->inList('role', self::ROLES, __(self::ERROR_ROLE_NOT_IN_LIST, implode('", "', self::ROLES)))
            ->email('email')->notEmpty('email')->requirePresence('email', 'create')
            ->add('email', [
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => __(self::ERROR_EMAIL_UNIQUE),
                ],
            ])
            ->notEmpty('password')->requirePresence('password', 'create');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->isUnique(['email'], __(self::ERROR_EMAIL_UNIQUE)));
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
    public function findAuth(Query $query): Query
    {
        return $query;
    }

    /**
     * Find recently created.
     *
     * Finds the recent created users by their registration date.
     *
     * @param Query $query The original query.
     * @return Query The updated query.
     */
    public function findRecentlyCreated(Query $query): Query
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
    public function findRecentlyActive(Query $query): Query
    {
        return $query->orderDesc('last_seen')->limit(self::LIMIT_DASHBOARD);
    }
}
