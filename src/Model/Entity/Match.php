<?php
namespace OurSociety\Model\Entity;

use Cake\ORM\Entity;

/**
 * Match Entity
 *
 * @property int $id
 * @property int $answer_id
 * @property int $user_id
 * @property double $match
 * @property int $importance
 *
 * @property \OurSociety\Model\Entity\Answer $answer
 */
class Match extends Entity
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
        'answer_id' => true,
        'user_id' => true,
        'match' => true,
        'answer' => true,
        'importance' => true
    ];
}
