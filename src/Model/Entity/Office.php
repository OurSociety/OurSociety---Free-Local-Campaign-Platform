<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

/**
 * Office Entity
 *
 * @property string $id
 * @property string $electoral_district_id
 * @property string $name
 *
 * @property ElectoralDistrict $electoral_district
 */
class Office extends AppEntity
{
}
