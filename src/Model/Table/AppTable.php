<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\ORM\Behavior\TimestampBehavior;
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

        $this->_validatorClass = \OurSociety\Validation\Validator::class;

        $this->addBehavior(OrderlyBehavior::class);
        $this->addBehavior(TimestampBehavior::class);

        if ($this->getSchema()->column('slug') !== null) {
            $this->addBehavior(SlugBehavior::class);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validationDefault(CakeValidator $validator): AppValidator
    {
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
}
