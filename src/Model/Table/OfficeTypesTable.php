<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\ORM\Association\HasMany;

/**
 * OfficeTypesTable.
 *
 * @property HasMany|UsersTable $Users
 */
class OfficeTypesTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->hasMany('Users');
    }
}
