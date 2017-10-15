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
    const TYPES = [
        self::TYPE_BOOL => 'Yes or No',
        self::TYPE_SCALE => 'Sliding scale',
    ];

    const TYPE_BOOL = 'yes/no';

    const TYPE_SCALE = 'scale';

    public function getIcon(): string
    {
        return 'question';
    }

    public function printQuestion(): string
    {
        // TODO: Doesn't play well with questions edited with WYSIWYG editor.
        /*
        return preg_replace(
            [
                '/^(<p.*?>)?/', // match start of question including opening tag (if any)
                '/(<\/p>)?$/', // match end of question including closing tag (if any)
            ],
            [
                '$1“', // add left double-quotation mark inside opening tag (if any)
                '$1”', // add right double-quotation mark inside closing tag (if any)
            ],
            $this->_properties['question']
        );
        */

        return $this->_properties['question'];
    }
}
