<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use ArrayAccess;
use ArrayObject;
use Cake\Datasource\EntityInterface as Entity;
use Cake\Event\Event;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator as CakeValidator;
use Muffin\Orderly\Model\Behavior\OrderlyBehavior;
use Muffin\Slug\Model\Behavior\SlugBehavior;
use OurSociety\Validation\Validator as AppValidator;

/**
 * Application table.
 *
 * Base class for all tables in the application.
 *
 * @mixin TimestampBehavior
 */
abstract class AppTable extends Table
{
    public static function instance(?string $alias = null, ?array $options = [])
    {
        $alias = $alias ?: preg_replace('#.*\\\\(.*)Table#', '$1', static::class);
        $options += TableRegistry::exists('Questions') ? [] : ['className' => static::class];

        return TableRegistry::get($alias, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->_validatorClass = AppValidator::class;

        $this->addBehavior(OrderlyBehavior::class, $this->getDefaultOrder());
        $this->addBehavior(TimestampBehavior::class);

        if ($this->getSchema()->column('slug') !== null) {
            $this->addBehavior(SlugBehavior::class, ['onUpdate' => true]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validationDefault(CakeValidator $validator): AppValidator
    {
        /** @var $validator AppValidator */

        $validator
            // id
            ->uuid('id')
            ->allowEmpty('id', 'create')
        ;


        if ($this->getSchema()->column('slug') !== null) {
            $validator
                // slug
                //->requirePresence('slug', 'create') // TODO: Breaks registration
                ->notEmpty('slug');
        }

        return $validator;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options): void
    {
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = trim($value);
            }
        }
    }

    /**
     * Upsert (update/insert).
     *
     * Updates a record if one is found matching conditions, otherwise inserts a new record.
     *
     * @param array $conditions The conditions to find existing record.
     * @param array $data The data to save (will be merged with `$conditions`).
     * @param array|ArrayAccess $options The options to use when saving.
     * @return Entity The saved entity.
     * @throws PersistenceFailedException When the entity couldn't be saved.
     */
    public function upsert(array $conditions, array $data = [], array $options = []): Entity
    {
        $options += ['fail' => true];
        $saveMethod = $options['fail'] === true ? 'saveOrFail' : 'save';
        unset($options['fail']);

        $existing = $this->find()->where($conditions)->first();

        $data += $conditions;
        if ($existing === null) {
            $entity = $this->newEntity($data);
        } else {
            $entity = $this->patchEntity($existing, $data);
        }

        return $this->{$saveMethod}($entity, $options);
    }

    protected function getDefaultOrder(): array
    {
        return [];
    }
}
