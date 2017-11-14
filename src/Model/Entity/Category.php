<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\ORM\TableRegistry;

/**
 * Category Entity
 *
 * @property string $id The UUID.
 * @property string $slug The slug/icon CSS class suffix.
 * @property string $name The name of the category.
 * @property int $question_count The number of questions in this category.
 * @property int $match The value match percentage for a user (not persisted, but sometimes stored here) TODO: decide
 * @property \Cake\I18n\FrozenTime $created The created timestamp.
 * @property \Cake\I18n\FrozenTime $modified The modified timestamp.
 *
 * @property \OurSociety\Model\Entity\Question[] $questions
 * @property \OurSociety\Model\Entity\User[] $users
 * @property \OurSociety\Model\Entity\ValueMatch[] $value_match
 */
class Category extends AppEntity
{
    public static function random(array $data = null): self
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return TableRegistry::get('Categories')->find()->order('RAND()')->firstOrFail();
    }

    public function getIcon(): string
    {
        return 'archive';
    }
}
