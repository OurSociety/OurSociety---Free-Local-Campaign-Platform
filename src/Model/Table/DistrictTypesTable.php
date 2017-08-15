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
    public static function instance(?string $alias = null, ?array $options = []): self
    {
        return parent::instance($alias, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->hasMany('ElectoralDistricts', ['foreignKey' => 'type_id']);
    }
}
