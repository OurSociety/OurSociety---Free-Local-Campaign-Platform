<?php
declare(strict_types = 1);

namespace OurSociety\Test\Fixture;

use Cake\Auth\AbstractPasswordHasher;
use Cake\Auth\DefaultPasswordHasher;
use Cake\TestSuite\Fixture\TestFixture;
use Faker\Factory as GeneratorFactory;
use Faker\Generator;
use OurSociety\Model\Table\UsersTable;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    public const EMAIL_ADMIN = 'team@oursociety.org';
    public const EMAIL_CITIZEN = 'citizen@example.net';
    public const EMAIL_POLITICIAN = 'politician@example.org';
    public const DEFAULT_PASSWORD = 'password';

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
        'email' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'first_name' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'last_name' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'token' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'token_expires' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'api_token' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'activation_date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'tos_date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'is_superuser' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'role' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'user', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'last_seen' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'role' => UsersTable::ROLE_ADMIN,
            'name' => 'OurSociety Team',
            'slug' => 'oursociety-team',
            'email' => self::EMAIL_ADMIN,
        ],
        [
            'role' => UsersTable::ROLE_CITIZEN,
            'name' => 'Citizenfour',
            'slug' => 'citizenfour',
            'email' => self::EMAIL_CITIZEN,
        ],
        [
            'role' => UsersTable::ROLE_POLITICIAN,
            'name' => 'Augustus Octavius Bacon',
            'slug' => 'augustus-octavius-bacon',
            'email' => self::EMAIL_POLITICIAN,
        ],
        /*
         * 'id' => '1cc7712e-e0f8-4704-9c04-1601d70abceb',
         * 'slug' => 'Lorem ipsum dolor sit amet',
         * 'email' => 'Lorem ipsum dolor sit amet',
         * 'password' => 'Lorem ipsum dolor sit amet',
         * 'name' => 'Lorem ipsum dolor sit amet',
         * 'first_name' => 'Lorem ipsum dolor sit amet',
         * 'last_name' => 'Lorem ipsum dolor sit amet',
         * 'token' => 'Lorem ipsum dolor sit amet',
         * 'token_expires' => '2017-07-07 11:08:36',
         * 'api_token' => 'Lorem ipsum dolor sit amet',
         * 'activation_date' => '2017-07-07 11:08:36',
         * 'tos_date' => '2017-07-07 11:08:36',
         * 'active' => 1,
         * 'is_superuser' => 1,
         * 'role' => 'Lorem ipsum dolor sit amet',
         * 'last_seen' => '2017-07-07 11:08:36',
         * 'created' => '2017-07-07 11:08:36',
         * 'modified' => '2017-07-07 11:08:36'
         */
    ];

    public function init(): void
    {
        $this->generator = GeneratorFactory::create();
        $this->generator->seed(1234);

        $this->passwordHasher = new DefaultPasswordHasher;

        $this->records = collection($this->records)->map(function (array $record) {
            return $record + [
                    'active' => true,
                    'id' => $this->generator->uuid,
                    'password' => $this->passwordHasher->hash(self::DEFAULT_PASSWORD),
                ];
        });

        parent::init();
    }
}
