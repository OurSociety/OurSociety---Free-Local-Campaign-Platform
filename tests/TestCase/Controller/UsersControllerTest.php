<?php
declare(strict_types = 1);

namespace OurSociety\Test\TestCase\Controller;

use OurSociety\Controller\UsersController;
use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

class UsersControllerTest extends IntegrationTestCase
{
    public function testForgot(): void
    {
        $this->get(['_name' => 'users:forgot']);
        $this->assertResponseOk();
        $this->assertResponseContains('Please enter your email to reset your password');
        $this->assertResponseContains('Email');
        $this->assertResponseContains('Submit');

        $expected = true;
        switch ($expected) {
            case true:
                $this->post(['_name' => 'users:forgot'], ['email' => UsersFixture::EMAIL_CITIZEN]);
                $this->assertResponseSuccess();
                $this->assertResponseCode(302);
                $this->assertRedirect(['_name' => 'users:login']);

                $this->session((array)$this->_requestSession->read());
                $this->get(['_name' => 'users:login']);
                $this->assertResponseContains(UsersController::MESSAGE_FORGOT_SUCCESS);
                break;
            case false:
                $this->markTestIncomplete('Missing negative case.'); // TODO: Implement failure case.
                break;
        }
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

        $this->post(['_name' => 'users:login'], $data);
        switch ($expected) {
            case 'success':
                $this->assertResponseSuccess();
                $this->assertResponseCode(302);
                $this->assertRedirect($redirect);

                $authenticatedSession = (array)$this->_requestSession->read();
                $this->session($authenticatedSession);
                $this->get($redirect);
                $this->assertResponseOk();
                $this->assertResponseContains(UsersController::MESSAGE_LOGIN_SUCCESS);
                $this->assertResponseNotContains(UsersController::MESSAGE_LOGIN_ERROR);
                $this->assertResponseContains('Signed in as');
                $this->assertResponseContains('Logout');
                $this->assertResponseNotContains('Login');

                $this->session($authenticatedSession);
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
                    'password' => UsersFixture::DEFAULT_PASSWORD,
                ],
                'expected' => 'success',
                'redirect' => ['_name' => 'citizen:dashboard'],
            ],
            'success (politician)' => [
                'data' => [
                    'email' => UsersFixture::EMAIL_POLITICIAN,
                    'password' => UsersFixture::DEFAULT_PASSWORD,
                ],
                'expected' => 'success',
                'redirect' => ['_name' => 'politician:dashboard'],
            ],
            'success (admin)' => [
                'data' => [
                    'email' => UsersFixture::EMAIL_ADMIN,
                    'password' => UsersFixture::DEFAULT_PASSWORD,
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
        $this->loginAsAdmin();
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

                $this->session((array)$this->_requestSession->read());
                $this->get(['_name' => 'pages:home']);
                $this->assertResponseOk();
                $this->assertResponseContains('Account successfully created');
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
}
