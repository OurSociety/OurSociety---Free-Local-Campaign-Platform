<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

/**
 * CategoriesUser Entity
 *
 * @property string $id
 * @property string $category_id
 * @property string $user_id
 * @property int $answer_count
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \OurSociety\Model\Entity\Category $category
 * @property \OurSociety\Model\Entity\User $user
 */
class CategoriesUser extends AppEntity
{
    public function getIcon(): string
    {
        return 'arrows-h';
    }
}
