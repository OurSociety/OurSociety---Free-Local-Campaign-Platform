<?php
declare(strict_types = 1);

namespace OurSociety\Test\TestCase\Controller\Admin;

use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

class DashboardControllerTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideDashboard
     * @param string $expected The expected case.
     * @param string|null $email The email of the user to authenticate as, if any.
     */
    public function testDashboard(string $expected, string $email = null): void
    {
        $this->auth($email);
        $this->get(['_name' => 'admin:dashboard']);

        switch ($expected) {
            case 'success':
                $this->assertResponseOk();
                $this->assertResponseContains('Admin Dashboard');
                $this->assertResponseContains('Recently Created Users');
                $this->assertResponseContains('Recently Active Users');
                break;
            case 'error':
                $this->assertResponseSuccess();
                $this->assertResponseCode(302);
                $this->assertRedirect(['_name' => 'users:login', '?' => ['redirect' => '/admin']]);
                break;
        }
    }

    public function provideDashboard(): array
    {
        return [
            'unauthenticated' => [
                'expected' => 'error',
            ],
            'admin' => [
                'expected' => 'success',
                'email' => UsersFixture::ADMIN_EMAIL,
            ],
        ];
    }
}
