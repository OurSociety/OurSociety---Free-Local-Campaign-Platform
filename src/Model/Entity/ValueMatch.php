<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\ORM\Entity;

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
class ValueMatch extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
