<?php
declare(strict_types=1);

use Cake\Auth\DefaultPasswordHasher as PasswordHasher;
use Cake\I18n\Time;
use Cake\Utility\Text;
use OurSociety\Migration as App;
use OurSociety\Model\Entity\User;

/**
 * Users seeder.
 *
 * Seeds the `users` table with an admin user. Use the "forgot password" to set the initial password.
 */
class UsersSeed extends App\AbstractSeed
{
    public function run(): void
    {
        $table = $this->table('users');
        $abort = $this->assertEmptyTable($table);
        if ($abort) {
            return;
        }

        $data = [
            [
                'id' => Text::uuid(),
                'slug' => 'oursociety-team',
                'email' => 'team@oursociety.org',
                'password' => (new PasswordHasher)->hash(\OurSociety\Test\Fixture\UsersFixture::PASSWORD_DEFAULT),
                'name' => 'OurSociety Team',
                'verified' => Time::now()->format('Y-m-d H:i:s'),
                'role' => User::ROLE_ADMIN,
                'picture' => 'logo.png'
            ],
            [
                'id' => Text::uuid(),
                'slug' => 'test-politician',
                'email' => 'team+politician@oursociety.org',
                'password' => (new PasswordHasher)->hash(\OurSociety\Test\Fixture\UsersFixture::PASSWORD_DEFAULT),
                'name' => 'Test Politician',
                'verified' => Time::now()->format('Y-m-d H:i:s'),
                'role' => User::ROLE_POLITICIAN,
                'zip' => 12345,
                'picture' => 'example-politician.png'
            ],
            [
                'id' => Text::uuid(),
                'slug' => 'test-citizen',
                'email' => 'team+citizen@oursociety.org',
                'password' => (new PasswordHasher)->hash(\OurSociety\Test\Fixture\UsersFixture::PASSWORD_DEFAULT),
                'name' => 'Test Citizen',
                'verified' => Time::now()->format('Y-m-d H:i:s'),
                'role' => User::ROLE_CITIZEN,
                'zip' => 12345,
            ],
            [
                'id' => Text::uuid(),
                'role' => User::ROLE_POLITICIAN,
                'name' => 'Imported Politician',
                'slug' => 'imported-politician',
                'email' => 'imported-politician@example.com',
                'email_temp' => 'possible.real.email@example.com',
                'phone' => '(123) 456-7890 x1234 / 123-213-2345',
                'password' => 'unclaimed',
                'address_1' => '123 Street, Town, ST 01234',
                'position' => 'State Senate District 8',
                'incumbent' => 0,
                'token' => '123456',
            ],
        ];

        $table->insert($data)->save();
    }
}
