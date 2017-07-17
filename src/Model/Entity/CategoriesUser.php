<?php
namespace OurSociety\Model\Entity;

use Cake\ORM\Entity;

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
class CategoriesUser extends Entity
{
    public function __construct(array $properties = [], array $options = [])
    {
        parent::__construct($properties, $options);

        $this->_accessible = ['*' => true, 'id' => false];
    }
}
