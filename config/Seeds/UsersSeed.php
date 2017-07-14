<?php
declare(strict_types=1);

use Cake\Auth\DefaultPasswordHasher as PasswordHasher;
use Cake\I18n\Time;
use Cake\Utility\Security;
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

        $password = bin2hex(Security::randomBytes(16));

        $data = [
            [
                'id' => Text::uuid(),
                'slug' => 'oursociety-team',
                'email' => 'team@oursociety.org',
                'password' => (new PasswordHasher)->hash($password),
                'name' => 'OurSociety Team',
                'active' => Time::now()->format('Y-m-d H:i:s'),
                'role' => User::ROLE_ADMIN,
            ]
        ];

        $table->insert($data)->save();

        $this->getOutput()->writeln(sprintf(' <comment>Admin password is:</comment> <error>%s</error>', $password));
    }
}
