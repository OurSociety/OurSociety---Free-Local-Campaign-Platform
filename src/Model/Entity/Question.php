<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

/**
 * Question Entity
 *
 * @property string $id
 * @property string $category_id
 * @property int $level
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
class Question extends AppEntity
{
    const TYPE_BOOL = 'yes/no';
    const TYPE_SCALE = 'scale';
    const TYPES = [
        self::TYPE_BOOL => 'Yes or No',
        self::TYPE_SCALE => 'Sliding scale',
    ];
}
