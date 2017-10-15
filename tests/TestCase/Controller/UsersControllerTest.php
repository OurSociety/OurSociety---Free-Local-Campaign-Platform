<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use OurSociety\Action\LoginAction;
use OurSociety\Controller\UsersController;
use OurSociety\Model\Entity\User;
use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;
use OurSociety\TestSuite\Traits;

class UsersControllerTest extends IntegrationTestCase
{
    use Traits\EmailAssertionsTrait;

    private static function findRecord(string $email): User
    {
        /** @var User $user */
        $user = TableRegistry::get('Users')->find()->where(['email' => $email])->firstOrFail();

        return $user;
    }

    /**
     * @dataProvider provideForgot
     * @param bool $expected The expected case.
     */
    public function testForgot(bool $expected): void
    {
        $this->get(['_name' => 'users:forgot']);
        $this->assertResponseOk();
        $this->assertResponseContains('Please enter your email to reset your password');
        $this->assertResponseContains('Email');
        $this->assertResponseContains('Submit');

        switch ($expected) {
            case true:
                $this->post(['_name' => 'users:forgot'], ['email' => UsersFixture::CITIZEN_EMAIL]);
                $this->assertResponseSuccess();
                $this->assertResponseCode(302);
                $this->assertRedirect(['_name' => 'users:reset', '?' => ['email' => UsersFixture::CITIZEN_EMAIL]]);
                $this->assertFlash(UsersController::MESSAGE_FORGOT_SUCCESS);
                self::assertEmailTo(UsersFixture::CITIZEN_EMAIL);
                self::assertEmailSubject('Forgot password');
                $encodedEmail = urlencode(UsersFixture::CITIZEN_EMAIL);
                self::assertEmailBody(UsersFixture::CITIZEN_1_NAME, <<<EMAIL
Your verification code is: {TOKEN}

Alternatively, click or copy the following address into your web browser:

https://test.oursociety.org/reset-password?email=${encodedEmail}&token={TOKEN}
EMAIL
                );
                break;
            case false:
                $this->post(['_name' => 'users:forgot'], ['email' => 'unknown@example.com']);
                $this->assertResponseOk();
                $this->assertResponseContains(UsersController::MESSAGE_FORGOT_ERROR);
                break;
        }
    }

    public function provideForgot(): array
    {
        return [
            'success' => ['expected' => true],
            'error (wrong email)' => ['expected' => false],
        ];
    }

    /**
     * @dataProvider provideLogin
     * @param array $data The data to POST to login form.
     * @param string $expected The expected case.
     * @param array|null $redirect The expected redirect location.
     */
    public function testLogin(array $data, string $expected, array $redirect = null): void
    {
        $this->get(['_name' => 'users:login']);
        $this->assertResponseOk();
        $this->assertResponseContains('Email');
        $this->assertResponseContains('Password');
        $this->assertResponseContains('Sign In');
        $this->assertResponseContains('Keep me signed in');
        $this->assertResponseContains('Forgot password?');

        $this->post(['_name' => 'users:login'], $data);
        switch ($expected) {
            case 'success':
                $this->assertResponseSuccess();
                $this->assertResponseCode(302);
                $this->assertRedirect($redirect);
                self::assertTimeWithinLast('1 second', self::findRecord($data['email'])->last_seen);
                $this->resumeSession();
                $this->get($redirect);
                if ($this->_response->getStatusCode() === 302) {
                    $this->get(parse_url($this->_response->getHeader('Location')[0])['path']);
                }
                $this->assertResponseOk();
                $this->assertResponseContains(LoginAction::MESSAGE_LOGIN_SUCCESS);
                $this->assertResponseNotContains(LoginAction::MESSAGE_LOGIN_ERROR);
                $this->assertResponseContains('Sign Out');
                $this->assertResponseNotContains('Sign In');
                $this->resumeSession();
                $this->get(['_name' => 'users:login']);
                $this->assertResponseSuccess();
                $this->assertResponseCode(302);
                $this->assertRedirect($redirect);
                break;
            case 'error':
                $this->assertResponseOk();
                $this->assertResponseContains(LoginAction::MESSAGE_LOGIN_ERROR);
                $this->assertResponseNotContains(LoginAction::MESSAGE_LOGIN_SUCCESS);
                break;
        }
    }

    public function provideLogin(): array
    {
        return [
            'success (citizen)' => [
                'data' => [
                    'email' => UsersFixture::CITIZEN_EMAIL,
                    'password' => UsersFixture::PASSWORD_DEFAULT,
                ],
                'expected' => 'success',
                'redirect' => ['_name' => 'citizen:dashboard'],
            ],
            'success (politician)' => [
                'data' => [
                    'email' => UsersFixture::POLITICIAN_EMAIL,
                    'password' => UsersFixture::PASSWORD_DEFAULT,
                ],
                'expected' => 'success',
                'redirect' => ['_name' => 'politician:dashboard'],
            ],
            'success (admin)' => [
                'data' => [
                    'email' => UsersFixture::ADMIN_EMAIL,
                    'password' => UsersFixture::PASSWORD_DEFAULT,
                ],
                'expected' => 'success',
                'redirect' => ['_name' => 'admin:dashboard'],
            ],
            'error (invalid credentials)' => [
                'data' => [
                    'email' => UsersFixture::ADMIN_EMAIL,
                    'password' => 'incorrect',
                ],
                'expected' => 'error',
            ],
        ];
    }

    /**
     * @dataProvider provideLogout
     * @param string|null $email The email of user to authenticate as, if any.
     */
    public function testLogout(?string $email = null): void
    {
        $this->auth($email);
        $this->get(['_name' => 'users:logout']);
        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect(['_name' => 'users:login']);
    }

    public function provideLogout(): array
    {
        return [
            'success (signed in)' => ['email' => UsersFixture::ADMIN_EMAIL],
            'success (NOT signed in)' => ['email' => null],
        ];
    }

    /**
     * @dataProvider provideRegister
     * @param string $expected The expected case.
     * @param array $data The data to POST to the form.
     * @param string|null $error The error message, if any.
     */
    public function testRegister(string $expected, array $data, string $error = null): void
    {
        $this->get(['_name' => 'users:register']);
        $this->assertResponseOk();
        $this->assertResponseContains('Register an account');
        $this->assertResponseContains('Full name');
        $this->assertResponseContains('Email address');
        $this->assertResponseContains('Password');
        $this->assertResponseContains('Register');

        $this->post(['_name' => 'users:register'], ['method' => '_POST'] + $data);
        switch ($expected) {
            case 'success':
                $this->assertResponseSuccess();
                $this->assertResponseCode(302);
                $this->assertRedirect(['_name' => 'citizen:dashboard']);
                $this->assertFlash('Account successfully created');
                $this->resumeSession();
                $this->get(['_name' => 'citizen:dashboard']);
                $this->assertResponseSuccess();
                break;
            case 'error':
                $this->assertResponseOk();
                $this->assertResponseContains('Please fix the errors and try again');
                $this->assertResponseContains($error);
                break;
        }
    }

    public function provideRegister(): array
    {
        return [
            'success' => [
                'expected' => 'success',
                'data' => [
                    'name' => 'Test user',
                    'email' => 'test@example.com',
                    'password' => 'password',
                ],
            ],
            // TODO: Determine why this isn't failing in tests when it works in browser.
            //'error (duplicate email)' => [
            //    'expected' => 'error',
            //    'data' => [
            //        'name' => 'Test user',
            //        'email' => UsersFixture::EMAIL_CITIZEN,
            //        'password' => 'password',
            //    ],
            //    'error' => 'This email is already in use',
            //],
        ];
    }

    /**
     * @dataProvider provideReset
     * @param string $case The expected case.
     * @param array $query The query string parameters, if any.
     * @param array $data The form data.
     * @param User|null $user The user to authenticate as, if any.
     * @return void
     */
    public function testReset(string $case, array $query = [], array $data = [], ?User $user = null): void
    {
        $this->get(['_name' => 'users:reset', '?' => $query]);
        $this->assertResponseOk();
        if ($user === null) {
            if (!isset($query['token'])) {
                $this->assertResponseContains('Verification code');
            }
            if (!isset($query['email'])) {
                $this->assertResponseContains('Email');
            }
        } else {
            $this->assertResponseContains('Current password');
        }
        $this->assertResponseContains('New password');

        $this->post(['_name' => 'users:reset', '?' => $query], ['_method' => 'POST'] + $data);
        switch ($case) {
            case 'success':
                $this->assertResponseSuccess();
                $this->assertResponseCode(302);
                $this->assertRedirect(['_name' => 'users:login', '?' => ['email' => UsersFixture::CITIZEN_EMAIL]]);
                $this->assertFlash(UsersController::MESSAGE_RESET_SUCCESS);
                $this->testLogin([
                    'email' => UsersFixture::CITIZEN_EMAIL,
                    'password' => UsersFixture::PASSWORD_RESET,
                ], 'success', ['_name' => 'citizen:dashboard']);
                break;
            case 'error':
            case 'tokenNotFound':
                $this->assertResponseError();
                $this->assertResponseCode(404);
                $this->assertResponseContains('Token not found');
                break;
            case 'tokenExpired':
                $this->assertResponseError();
                $this->assertResponseCode(400);
                $this->assertResponseContains('Token has expired');
                break;
        }
    }

    public function provideReset(): array
    {
        return [
            'success (no query string)' => [
                'case' => 'success',
                'query' => [],
                'data' => [
                    'token' => UsersFixture::CITIZEN_TOKEN,
                    'email' => UsersFixture::CITIZEN_EMAIL,
                    'password' => UsersFixture::PASSWORD_RESET,
                ],
            ],
            'success (email in query string)' => [
                'case' => 'success',
                'query' => [
                    'email' => UsersFixture::CITIZEN_EMAIL,
                ],
                'data' => [
                    'token' => UsersFixture::CITIZEN_TOKEN,
                    'password' => UsersFixture::PASSWORD_RESET,
                ],
            ],
            'success (token in query string)' => [
                'case' => 'success',
                'query' => [
                    'token' => UsersFixture::CITIZEN_TOKEN,
                ],
                'data' => [
                    'email' => UsersFixture::CITIZEN_EMAIL,
                    'password' => UsersFixture::PASSWORD_RESET,
                ],
            ],
            'success (email and token in query string)' => [
                'case' => 'success',
                'query' => [
                    'token' => UsersFixture::CITIZEN_TOKEN,
                    'email' => UsersFixture::CITIZEN_EMAIL,
                ],
                'data' => [
                    'password' => UsersFixture::PASSWORD_RESET,
                ],
            ],
            'error (token not found)' => [
                'case' => 'tokenNotFound',
                'query' => [],
                'data' => [],
            ],
            'error (token expired)' => [
                'case' => 'tokenExpired',
                'query' => [],
                'data' => ['token' => 'expired'],
            ],
            //'success (authenticated user)' => [
            //    'case' => 'success',
            //    'query' => [],
            //    'data' => [],
            //    'user' => UsersFixture::EMAIL_CITIZEN, // TODO: Password change page for authenticated users.
            //],
        ];
    }
}
