<?php
namespace OurSociety\Model\Entity;

use Cake\ORM\Entity;

/**
 * Node Entity
 *
 * @property string $id
 * @property string $table
 * @property string $foreign_key
 * @property string $parent_id
 * @property int $level
 * @property int $lft
 * @property int $rght
 *
 * @property \OurSociety\Model\Entity\ParentNode $parent_node
 * @property \OurSociety\Model\Entity\ChildNode[] $child_nodes
 */
class Node extends Entity
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
