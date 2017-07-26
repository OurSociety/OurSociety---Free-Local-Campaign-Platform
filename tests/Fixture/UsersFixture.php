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
    public const ID_POLITICIAN = '83f72fd4-847f-4f1f-a0d0-03185fd9640e';
    public const EMAIL_ADMIN = 'team@oursociety.org';
    public const EMAIL_CITIZEN = 'citizen@example.net';
    public const EMAIL_POLITICIAN = 'politician@example.org';
    public const TOKEN_CITIZEN = 'ABC123';
    public const PASSWORD_DEFAULT = 'democracy';
    public const PASSWORD_RESET = 'new password';
    public const SLUG_POLITICIAN = 'augustus-octavius-bacon';
    public const NAME_POLITICIAN = 'Augustus Octavius Bacon';

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
        'slug' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'email_temp' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'zip' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'phone' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'role' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => 'citizen', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'answer_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'picture' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'address_1' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'address_2' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'city' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'state' => ['type' => 'string', 'length' => 2, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'birth_name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'birth_city' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'birth_state' => ['type' => 'string', 'length' => 2, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'birth_country' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'born' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'position' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'incumbent' => ['type' => 'integer', 'length' => 3, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'token' => ['type' => 'string', 'length' => 6, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'token_expires' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'last_seen' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'verified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
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
        'verified' => 'now',
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
            'email' => self::EMAIL_ADMIN,
            'picture' => 'logo.png'
        ],
        [
            'role' => User::ROLE_CITIZEN,
            'name' => 'Citizenfour',
            'email' => self::EMAIL_CITIZEN,
            'token' => self::TOKEN_CITIZEN,
            'token_expires' => '1 hour',
            'picture' => 'example-politician.png'
        ],
        [
            'id' => self::ID_POLITICIAN,
            'role' => User::ROLE_POLITICIAN,
            'name' => self::NAME_POLITICIAN,
            'slug' => self::SLUG_POLITICIAN,
            'email' => self::EMAIL_POLITICIAN,
            'phone' => '(123) 456-7890',
            'birth_name' => 'John Doe II',
            'birth_city' => 'Edison',
            'birth_state' => 'NJ',
            'birth_country' => 'US',
            'born' => '1984-01-01',
        ],
        [
            'role' => User::ROLE_POLITICIAN,
            'name' => 'Imported Politician',
            'slug' => 'imported-politician',
            'email' => 'imported-politician@example.com',
            'email_temp' => 'possible.real.email@example.com',
            'phone' => '(123) 456-7890 x1234 / 123-213-2345',
            'password' => 'unclaimed',
            'token' => '123456',
            'token_expires' => null,
            'address_1' => '123 Street, Town, ST 01234',
            'position' => 'State Senate District 8',
            'incumbent' => false,
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
