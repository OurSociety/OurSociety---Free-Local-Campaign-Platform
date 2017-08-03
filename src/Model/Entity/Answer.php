<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

/**
 * Answer Entity
 *
 * @property string $id The answer ID.
 * @property string $question_id The question ID.
 * @property string $user_id The user ID.
 * @property string $name The answer human name.
 * @property int $answer The answer numerical value.
 * @property int $importance The question importance numerical value.
 * @property \Cake\I18n\FrozenTime $created The created timestamp.
 * @property \Cake\I18n\FrozenTime $modified The modified timestamp.
 *
 * @property \OurSociety\Model\Entity\Question $question
 * @property \OurSociety\Model\Entity\User $user
 */
class Answer extends AppEntity
{
    public const ANSWER_STRONGLY_AGREE = 100;
    public const ANSWER_SOMEWHAT_AGREE = 50;
    public const ANSWER_NEUTRAL = 0;
    public const ANSWER_SOMEWHAT_DISAGREE = -50;
    public const ANSWER_STRONGLY_DISAGREE = -100;

    public const ANSWER_YES = 75;
    public const ANSWER_NO = -75;

    public const ANSWERS_SCALE = [
        self::ANSWER_STRONGLY_AGREE => 'Strongly Agree',
        self::ANSWER_SOMEWHAT_AGREE => 'Somewhat Agree',
        self::ANSWER_NEUTRAL => 'No Opinion',
        self::ANSWER_SOMEWHAT_DISAGREE => 'Somewhat Disagree',
        self::ANSWER_STRONGLY_DISAGREE => 'Strongly Disagree',
    ];

    public const ANSWERS_BOOL = [
        self::ANSWER_YES => 'Yes',
        self::ANSWER_NO => 'No',
    ];

    public const IMPORTANCE_LITTLE = 1;
    public const IMPORTANCE_SOMEWHAT = 10;
    public const IMPORTANCE_VERY = 250;

    public const IMPORTANCE = [
        self::IMPORTANCE_LITTLE => 'A Little',
        self::IMPORTANCE_SOMEWHAT => 'Somewhat',
        self::IMPORTANCE_VERY => 'Very',
    ];

    public function __construct(array $properties = [], array $options = [])
    {
        parent::__construct($properties, $options);

        $this->setHidden(['answer']);
    }

    protected function _getImportance(): ?string
    {
        if (!isset($this->_properties['importance'])) {
            return null;
        }

        return self::IMPORTANCE[$this->_properties['importance']];
    }

    protected function _getName(): string
    {
        return self::ANSWERS_SCALE[$this->_properties['answer']]
            ?? self::ANSWERS_BOOL[$this->_properties['answer']];
    }
}
