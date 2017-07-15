<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Application table.
 *
 * Base class for all tables in the application.
 *
 * @mixin Behavior\TimestampBehavior
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

        $this->addBehavior('Muffin/Slug.Slug');
        $this->addBehavior('Timestamp');
    }

    /**
     * {@inheritdoc}
     */
    public function validationDefault(Validator $validator): Validator
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
