<?php
declare(strict_types = 1);

namespace OurSociety\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * User Entity
 *
 * @property string $id The UUID.
 * @property string $slug The slug.
 * @property string $email The email address.
 * @property int $zip The zip code.
 * @property string $phone The phone number.
 * @property string $password The password.
 * @property string $name The name.
 * @property string|null $token The verification token.
 * @property \Cake\I18n\FrozenTime|null $token_expires The expiry timestamp.
 * @property \Cake\I18n\FrozenTime|null $active The account activation timestamp.
 * @property string $role The role.
 * @property int $answer_count The amount of questions answered.
 * @property \Cake\I18n\FrozenTime|null $last_seen The last time the user logged in.
 * @property \Cake\I18n\FrozenTime $created The created timestamp.
 * @property \Cake\I18n\FrozenTime $modified The modified timestamp.
 */
class User extends Entity
{
    public const ROLES = [self::ROLE_ADMIN, self::ROLE_CITIZEN, self::ROLE_POLITICIAN];
    public const ROLE_ADMIN = 'admin';
    public const ROLE_CITIZEN = 'citizen';
    public const ROLE_POLITICIAN = 'politician';
    public const TOKEN_LENGTH = 6;
    public const TOKEN_EXPIRY_HOURS = 24;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $properties = [], array $options = [])
    {
        parent::__construct($properties, $options);

        $this->_accessible = ['*' => true, 'id' => false];
        $this->_hidden = ['password', 'token'];
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
     * With last seen.
     *
     * Populates `last_seen` value with current time.
     *
     * @return User
     */
    private function withLastSeen(): User
    {
        $user = clone $this;
        $user->last_seen = Time::now();

        return $user;
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

    /**
     * Seen.
     *
     * Convenience method to set a user as seen, which updated the last_seen timestamp.
     *
     * @return void
     */
    public function seen(): void
    {
        TableRegistry::get('Users')->saveOrFail($this->withLastSeen());
    }

    /**
     * Set password mutator.
     *
     * Automatically hashes password if not empty.
     *
     * @param string|null $password The plain text password.
     * @return string|null The hashed password.
     */
    protected function _setPassword(?string $password): ?string
    {
        return mb_strlen($password) > 0
            ? (new DefaultPasswordHasher)->hash($password)
            : null;
    }
}
