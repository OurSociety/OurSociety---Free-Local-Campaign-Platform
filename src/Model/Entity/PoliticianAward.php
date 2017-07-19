<?php
namespace OurSociety\Model\Entity;

use Cake\ORM\Entity;

/**
 * PoliticianAward Entity
 *
 * @property string $id
 * @property string $politician_id
 * @property string $name
 * @property string $description
 *
 * @property \OurSociety\Model\Entity\Politician $politician
 */
class PoliticianAward extends Entity
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
