<?php
declare(strict_types = 1);

namespace OurSociety\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Time;
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
 * @property string $token The verification token.
 * @property \Cake\I18n\Time $token_expires The expiry timestamp.
 * @property \Cake\I18n\Time $created The created timestamp.
 * @property \Cake\I18n\Time $modified The modified timestamp.
 */
class User extends Entity
{
    public const TOKEN_LENGTH = 6;
    public const TOKEN_EXPIRY_HOURS = 24;

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

    /**
     * Is token expired?
     *
     * @return bool True if token has expired, false otherwise.
     */
    public function isTokenExpired(): bool
    {
        $expires = $this->token_expires ?? Time::now();

        return $expires->lte(Time::now());
    }

    /**
     * With token.
     *
     * Generate `token` and `token_expires` values. Token expires in 24 hours.
     *
     * @return User
     */
    public function withToken(): User
    {
        $user = clone $this;

        /** @noinspection SpellCheckingInspection */
        $user->token = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, self::TOKEN_LENGTH);
        $user->token_expires = Time::now()->addHours(self::TOKEN_EXPIRY_HOURS);

        return $user;
    }
}
