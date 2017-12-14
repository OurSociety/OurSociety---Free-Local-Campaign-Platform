<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\Network\Exception\NotImplementedException;

/**
 * CandidatePostElectionStatus Entity
 *
 * @property string $id
 * @property string $name
 * @property string $id_vip
 * @property string $description
 */
class CandidatePostElectionStatus extends AppEntity
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
        'id_vip' => true,
        'description' => true,
    ];

    public function getIcon(): string
    {
        throw new NotImplementedException('No icon');
    }
}
