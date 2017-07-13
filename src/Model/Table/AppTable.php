<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Application table.
 *
 * Base class for all tables in the application.
 *
 * @mixin TimestampBehavior
 */
abstract class AppTable extends Table
{
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
        return $validator
            // id
            ->uuid('id')
            ->allowEmpty('id', 'create');
    }
}
