<?php
declare(strict_types = 1);

namespace OurSociety\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id The UUID.
 * @property string $role The role.
 * @property string $name The name.
 * @property string $email The email address.
 * @property string $password The password.
 * @property bool $active True if active, false otherwise.
 * @property \Cake\I18n\Time $created The created timestamp.
 * @property \Cake\I18n\Time $modified The modified timestamp.
 */
class User extends Entity
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $properties = [], array $options = [])
    {
        parent::__construct($properties, $options);

        $this->_accessible = ['*' => true, 'id' => false];
        $this->_hidden = ['password'];
    }

    protected function _setPassword($password): ?string
    {
        return mb_strlen($password) > 0
            ? (new DefaultPasswordHasher)->hash($password)
            : null;
    }
}
