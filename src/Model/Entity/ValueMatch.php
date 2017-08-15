<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

/**
 * ValueMatch Entity
 *
 * @property string $id
 * @property string $citizen_id
 * @property string $politician_id
 * @property string $category_id
 * @property float $true_match_percentage
 * @property float $match_percentage
 * @property float $error_percentage
 * @property int $sample_size
 *
 * @property \OurSociety\Model\Entity\User $citizen
 * @property \OurSociety\Model\Entity\User $politician
 * @property \OurSociety\Model\Entity\Category $category
 */
class ValueMatch extends AppEntity
{
}
