<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\ORM\Query;

/**
 * DistrictTypesTable.
 *
 * @method Query findByName(string $name)
 */
class DistrictTypesTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->hasMany('ElectoralDistricts', ['foreignKey' => 'type_id']);
    }
}
