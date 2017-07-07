<?php
declare(strict_types = 1);

namespace OurSociety\Test\TestCase\Controller;

use OurSociety\Controller\UsersController;
use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

class UsersControllerTest extends IntegrationTestCase
{
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
                /** @noinspection SpellCheckingInspection */
                $token = 'FEKRPJ';
                mt_srand(1);
                $this->post(['_name' => 'users:forgot'], ['email' => UsersFixture::EMAIL_CITIZEN]);
                mt_srand();
                $this->assertResponseSuccess();
                $this->assertResponseCode(302);
                $this->assertRedirect(['_name' => 'users:reset', '?' => ['email' => 'citizen@example.net']]);
                $this->assertFlash(UsersController::MESSAGE_FORGOT_SUCCESS);
                $this->assertEmailTo('citizen@example.net');
                $this->assertEmailSubject('Forgot password');
                $this->assertEmailBody('Citizenfour', <<<EMAIL
Your verification code is: ${token}

Alternatively, click or copy the following address into your web browser:

https://test.oursociety.org/reset?email=citizen%40example.net&token=${token}
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
        $this->assertResponseContains('Please enter your email and password');
        $this->assertResponseContains('Email');
        $this->assertResponseContains('Password');
        $this->assertResponseContains('Login');
        $this->assertResponseContains('Remember me');
        $this->assertResponseContains('Forgot Password');

        $this->post(['_name' => 'users:login'], $data);
        switch ($expected) {
            case 'success':
                $this->assertResponseSuccess();
                $this->assertResponseCode(302);
                $this->assertRedirect($redirect);
                $this->resumeSession();
                $this->get($redirect);
                $this->assertResponseOk();
                $this->assertResponseContains(UsersController::MESSAGE_LOGIN_SUCCESS);
                $this->assertResponseNotContains(UsersController::MESSAGE_LOGIN_ERROR);
                $this->assertResponseContains('Signed in as');
                $this->assertResponseContains('Logout');
                $this->assertResponseNotContains('Login');
                $this->resumeSession();
                $this->get(['_name' => 'users:login']);
                // TODO: Should redirect if they visit login page while logged in?
                $this->assertResponseOk();
                $this->assertResponseContains('Please enter your email and password');
                break;
            case 'error':
                $this->assertResponseOk();
                $this->assertResponseContains(UsersController::MESSAGE_LOGIN_ERROR);
                $this->assertResponseNotContains(UsersController::MESSAGE_LOGIN_SUCCESS);
                break;
        }
    }

    public function provideLogin(): array
    {
        return [
            'success (citizen)' => [
                'data' => [
                    'email' => UsersFixture::EMAIL_CITIZEN,
                    'password' => UsersFixture::PASSWORD_DEFAULT,
                ],
                'expected' => 'success',
                'redirect' => ['_name' => 'citizen:dashboard'],
            ],
            'success (politician)' => [
                'data' => [
                    'email' => UsersFixture::EMAIL_POLITICIAN,
                    'password' => UsersFixture::PASSWORD_DEFAULT,
                ],
                'expected' => 'success',
                'redirect' => ['_name' => 'politician:dashboard'],
            ],
            'success (admin)' => [
                'data' => [
                    'email' => UsersFixture::EMAIL_ADMIN,
                    'password' => UsersFixture::PASSWORD_DEFAULT,
                ],
                'expected' => 'success',
                'redirect' => ['_name' => 'admin:dashboard'],
            ],
            'error (invalid credentials)' => [
                'data' => [
                    'email' => UsersFixture::EMAIL_ADMIN,
                    'password' => 'incorrect',
                ],
                'expected' => 'error',
            ],
        ];
    }

    public function testLogout(): void
    {
        $this->auth(UsersFixture::EMAIL_ADMIN);
        $this->get(['_name' => 'users:logout']);
        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect(['_name' => 'users:login']);
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
        $this->assertResponseContains('Name');
        $this->assertResponseContains('Email');
        $this->assertResponseContains('Password');
        $this->assertResponseContains('Register');

        $this->post('/register', ['method' => '_POST'] + $data);
        switch ($expected) {
            case 'success':
                $this->assertResponseSuccess();
                $this->assertResponseCode(302);
                $this->assertRedirect(['_name' => 'pages:home']);
                $this->assertFlash('Account successfully created');
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
     * @param string|null $user The user to authenticate as, if any.
     * @return void
     */
    public function testReset(string $case, array $query = [], array $data = [], string $user = null): void
    {
        $this->auth($user);
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
                $this->assertRedirect(['_name' => 'users:login', '?' => ['email' => UsersFixture::EMAIL_CITIZEN]]);
                $this->assertFlash(UsersController::MESSAGE_RESET_SUCCESS);
                $this->testLogin([
                    'email' => UsersFixture::EMAIL_CITIZEN,
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
                    'token' => UsersFixture::TOKEN_CITIZEN,
                    'email' => UsersFixture::EMAIL_CITIZEN,
                    'password' => UsersFixture::PASSWORD_RESET,
                ],
            ],
            'success (email in query string)' => [
                'case' => 'success',
                'query' => [
                    'email' => UsersFixture::EMAIL_CITIZEN,
                ],
                'data' => [
                    'token' => UsersFixture::TOKEN_CITIZEN,
                    'password' => UsersFixture::PASSWORD_RESET,
                ],
            ],
            'success (token in query string)' => [
                'case' => 'success',
                'query' => [
                    'token' => UsersFixture::TOKEN_CITIZEN,
                ],
                'data' => [
                    'email' => UsersFixture::EMAIL_CITIZEN,
                    'password' => UsersFixture::PASSWORD_RESET,
                ],
            ],
            'success (email and token in query string)' => [
                'case' => 'success',
                'query' => [
                    'token' => UsersFixture::TOKEN_CITIZEN,
                    'email' => UsersFixture::EMAIL_CITIZEN,
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
