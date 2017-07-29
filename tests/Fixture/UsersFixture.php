<?php
declare(strict_types = 1);

namespace OurSociety\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture
{
    public const ADMIN_EMAIL = 'team@oursociety.org';
    public const ADMIN_ID = '5205ae34-759e-11e7-9add-6c4008a68a60';
    public const CITIZEN_EMAIL = 'citizen@example.net';
    public const CITIZEN_ID = self::CITIZEN_1_ID;
    public const CITIZEN_TOKEN = '123456';
    public const CITIZEN_1_ID = '54064c3e-759e-11e7-b151-6c4008a68a60';
    public const CITIZEN_1_NAME = 'Citizen 1';
    public const CITIZEN_2_ID = '46b4b442-75aa-11e7-b7f8-6c4008a68a60';
    public const CITIZEN_3_ID = '847d8844-75aa-11e7-b6b8-6c4008a68a60';
    public const PASSWORD_DEFAULT = 'democracy';
    public const PASSWORD_RESET = 'new password';
    public const POLITICIAN_EMAIL = 'politician@example.org';
    public const POLITICIAN_ID = '573111be-759e-11e7-a371-6c4008a68a60';
    public const POLITICIAN_NAME = 'Augustus Octavius Bacon';
    public const POLITICIAN_SLUG = 'seth-kaper-dale';

    public $import = ['table' => 'users', 'connection' => 'fixtures'];
}
