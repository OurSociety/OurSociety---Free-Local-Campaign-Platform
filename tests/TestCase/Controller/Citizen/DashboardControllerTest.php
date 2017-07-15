<?php
declare(strict_types = 1);

namespace OurSociety\Test\TestCase\Controller\Citizen;

use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

class DashboardControllerTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideIndex
     * @param string $expected The expected case.
     * @param string|null $email The email of the user to authenticate as, if any.
     * @param array $userData The extra user data.
     * @param array|null $redirectUrl The redirect URL, if any.
     */
    public function testIndex(string $expected, string $email = null, ?array $userData = [], ?array $redirectUrl = null): void
    {
        $this->auth($email, $userData);
        $this->get(['_name' => 'citizen:dashboard']);

        switch ($expected) {
            case 'success':
                if ($redirectUrl === null) {
                    $this->assertResponseOk();
                    $this->assertResponseContains('Citizen Dashboard');
                    $this->assertResponseContains('What should OurSociety be thinking about?');
                } else {
                    $this->assertResponseSuccess();
                    $this->assertResponseCode(302);
                    $this->assertRedirect($redirectUrl);
                }
                break;
            case 'error':
                $this->assertResponseSuccess();
                $this->assertResponseCode(302);
                $this->assertRedirect(['_name' => 'users:login', '?' => ['redirect' => '/citizen']]);
                break;
        }
    }

    public function provideIndex(): array
    {
        return [
            'success (no zip => onboarding)' => [
                'expected' => 'success',
                'email' => UsersFixture::EMAIL_ADMIN,
                'userData' => ['zip' => null],
                'redirectUrl' => ['_name' => 'users:onboarding'],
            ],
            'success (no answers => questions)' => [
                'expected' => 'success',
                'email' => UsersFixture::EMAIL_ADMIN,
                'userData' => ['zip' => 12345],
                'redirectUrl' => ['_name' => 'citizen:questions'],
            ],
            'success (dashboard)' => [
                'expected' => 'success',
                'email' => UsersFixture::EMAIL_ADMIN,
                'userData' => ['zip' => 12345, 'answer_count' => 10],
            ],
            'error (unauthenticated)' => [
                'expected' => 'error',
            ],
        ];
    }
}
