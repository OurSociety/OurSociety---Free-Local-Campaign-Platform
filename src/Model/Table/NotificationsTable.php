<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Behavior\CounterCacheBehavior;
use OurSociety\Model\Entity\Notification;
use OurSociety\Validation\Validator as AppValidator;

/**
 * Notifications Model
 *
 * @property UsersTable|Association\BelongsTo $Users
 *
 * @method Notification get($primaryKey, $options = [])
 * @method Notification newEntity($data = null, array $options = [])
 * @method Notification[] newEntities(array $data, array $options = [])
 * @method Notification|bool save(Entity $entity, $options = [])
 * @method Notification patchEntity(Entity $entity, array $data, array $options = [])
 * @method Notification[] patchEntities($entities, array $data, array $options = [])
 * @method Notification findOrCreate($search, callable $callback = null, $options = [])
 */
class NotificationsTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('Users');

        $this->addBehavior(CounterCacheBehavior::class, [
            'Users' => [
                'unread_notification_count' => ['finder' => 'isUnread'],
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function validationDefault(CakeValidator $validator): AppValidator
    {
        return parent::validationDefault($validator)
            // title
            ->notEmpty('title')
            ->requirePresence('title', 'create')
            ->scalar('title')
            // body
            ->allowEmpty('body')
            ->scalar('body')
            // read
            ->dateTime('read')
            ->notEmpty('read');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['user_id'], 'Users'));
    }
}
