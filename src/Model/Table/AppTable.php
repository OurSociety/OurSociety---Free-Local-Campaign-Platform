<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

use ArrayAccess;
use ArrayObject;
use Cake\Datasource\EntityInterface as Entity;
use Cake\Event\Event;
use Cake\ORM\Behavior as Cake;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\ORM\Table;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Behavior as App;
use OurSociety\Validation\Validator as AppValidator;
use Search\Model\Behavior as Search;

/**
 * Application table.
 *
 * Base class for all tables in the application.
 *
 * @mixin App\AuditLogBehavior
 * @mixin App\DefaultOrderBehavior
 * @mixin Search\SearchBehavior
 * @mixin App\SlugBehavior
 * @mixin Cake\TimestampBehavior
 */
abstract class AppTable extends Table
{
    use Traits\ClassNameSupportTrait;
    use Traits\InvokableFinderTrait;

    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->_validatorClass = AppValidator::class;

        $this->addBehavior(App\AuditLogBehavior::class);
        $this->addBehavior(App\DefaultOrderBehavior::class);
        $this->addBehavior(Search\SearchBehavior::class);
        $this->addBehavior(App\SlugBehavior::class);
        $this->addBehavior(Cake\TimestampBehavior::class);
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
            ->allowEmpty('id', 'create');


        if ($this->hasSlugField()) {
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

    public function getSlugFieldName(): string
    {
        return 'slug';
    }

    public function hasSlugField(): bool
    {
        return $this->getSchema()->hasColumn($this->getSlugFieldName());
    }

    /**
     * Upsert (update/insert).
     *
     * Updates a record if one is found matching conditions, otherwise inserts a new record.
     *
     * @param array $conditions The conditions to find existing record.
     * @param array|null $data The data to save (will be merged with `$conditions`).
     * @param array|ArrayAccess|null $options The options to use when saving.
     * @return Entity The saved entity.
     * @throws PersistenceFailedException When the entity couldn't be saved.
     */
    public function upsert(array $conditions, ?array $data = null, ?array $options = null): Entity
    {
        $data = $data ?? [];
        $options = $options ?? [];

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

    public function getBySlug(string $slug): Entity
    {
        return $this->find('slugged', ['slug' => $slug])->firstOrFail();
    }
}
