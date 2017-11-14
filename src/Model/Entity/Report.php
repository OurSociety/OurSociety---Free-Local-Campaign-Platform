<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

/**
 * Report Entity
 *
 * @property string $id
 * @property string $question_id
 * @property string $user_id
 * @property string $body
 * @property bool $done
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \OurSociety\Model\Entity\Question $question
 * @property \OurSociety\Model\Entity\User $user
 */
class Report extends AppEntity
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
        'question_id' => true,
        'user_id' => true,
        'body' => true,
        'done' => true,
        'created' => true,
        'modified' => true,
        'question' => true,
        'user' => true,
    ];

    public function getIcon(): string
    {
        return 'flag';
    }
}
