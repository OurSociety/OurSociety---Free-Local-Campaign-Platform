<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\Network\Exception\NotImplementedException;

/**
 * State Entity
 *
 * @property string $id
 * @property string $name
 * @property string $election_administration_id
 *
 * @property \OurSociety\Model\Entity\ElectionAdministration $election_administration
 * @property \OurSociety\Model\Entity\Election[] $elections
 * @property \OurSociety\Model\Entity\ElectoralDistrict[] $electoral_districts
 */
class State extends AppEntity
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
        'name' => true,
        'election_administration_id' => true,
        'election_administration' => true,
        'elections' => true,
        'electoral_districts' => true,
    ];

    public function getIcon(): string
    {
        throw new NotImplementedException('No icon');
    }
}
