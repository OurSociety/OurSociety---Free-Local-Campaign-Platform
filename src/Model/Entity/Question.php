<?php
namespace OurSociety\Model\Entity;

use Cake\ORM\Entity;

/**
 * Question Entity
 *
 * @property string $id
 * @property string $category_id
 * @property string $question
 * @property string $type
 * @property int $citizen_answer_count
 * @property int $politician_answer_count
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \OurSociety\Model\Entity\Category $category
 * @property \OurSociety\Model\Entity\Answer[] $answers
 */
class Question extends Entity
{
    const TYPE_BOOL = 'yes/no';
    const TYPE_SCALE = 'scale';
    const TYPES = [
        self::TYPE_BOOL => 'Yes or No',
        self::TYPE_SCALE => 'Sliding scale',
    ];

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
