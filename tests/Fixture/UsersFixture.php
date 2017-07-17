<?php
declare(strict_types = 1);

namespace OurSociety\Test\Fixture;

use Cake\Auth\AbstractPasswordHasher;
use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Time;
use OurSociety\TestSuite\Fixture as App;
use Faker\Factory as GeneratorFactory;
use Faker\Generator;
use OurSociety\Model\Entity\User;

/**
 * UsersFixture
 */
class UsersFixture extends App\TestFixture
{
    public const EMAIL_ADMIN = 'team@oursociety.org';
    public const EMAIL_CITIZEN = 'citizen@example.net';
    public const EMAIL_POLITICIAN = 'politician@example.org';
    public const TOKEN_CITIZEN = 'ABC123';
    public const PASSWORD_DEFAULT = 'password';
    public const PASSWORD_RESET = 'new password';

    /**
     * @var Generator
     */
    public $generator;

    /**
     * @var AbstractPasswordHasher
     */
    public $passwordHasher;

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'slug' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'zip' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'phone' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'token' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'token_expires' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'active' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'role' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => 'citizen', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'answer_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'last_seen' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'UNQ_USER_EMAIL' => ['type' => 'unique', 'columns' => ['email'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_unicode_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    public $defaults = [
        'active' => 'now',
        'password' => self::PASSWORD_DEFAULT,
    ];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'role' => User::ROLE_ADMIN,
            'name' => 'OurSociety Team',
            'slug' => 'oursociety-team',
            'email' => self::EMAIL_ADMIN,
        ],
        [
            'role' => User::ROLE_CITIZEN,
            'name' => 'Citizenfour',
            'slug' => 'citizenfour',
            'email' => self::EMAIL_CITIZEN,
            'token' => self::TOKEN_CITIZEN,
            'token_expires' => '1 hour',
        ],
        [
            'role' => User::ROLE_POLITICIAN,
            'name' => 'Augustus Octavius Bacon',
            'slug' => 'augustus-octavius-bacon',
            'email' => self::EMAIL_POLITICIAN,
        ],
    ];

    public function init(): void
    {
        parent::init();

        $this->generator = GeneratorFactory::create();
        $this->passwordHasher = new DefaultPasswordHasher;

        $hashPasswords = function (array $record) {
            if (!isset($record['password'])) {
                $record['id'] = $this->generator->uuid;
            }

            if (isset($record['password'])) {
                $record['password'] = $this->passwordHasher->hash(self::PASSWORD_DEFAULT);
            }

            return $record;
        };

        $setTokenExpires = function (array $record) {
            if (isset($record['token'])) {
                $record['token_expires'] = Time::now()->addHours(24);
            }

            return $record;
        };

        $this->records = collection($this->records)
            ->map($hashPasswords)
            ->map($setTokenExpires);
    }
}
