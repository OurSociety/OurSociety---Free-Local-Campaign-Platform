<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use OurSociety\Model\Entity\User;
use OurSociety\TestSuite\IntegrationTestCase;

/**
 * Base test case for application controllers.
 */
class AppControllerTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideIsAuthorized
     * @param bool $expected True if expected to be authorized, false otherwise.
     * @param string|null $role The role of the user.
     * @param string $url The URL to test.
     */
    public function testIsAuthorized(bool $expected, string $role, string $url): void
    {
        /** @var User $user */
        $user = TableRegistry::get('Users')->find()->where(compact('role'))->firstOrFail();

        $this->auth($user->email);
        $this->get($url);

        switch ($expected) {
            case true:
                $this->assertResponseSuccess();
                break;
            case false:
                $this->assertResponseError();
                break;
        }
    }

    public function provideIsAuthorized(): array
    {
        return [
            'citizen role can access public prefix' => [
                'expected' => true,
                'role' => User::ROLE_CITIZEN,
                'url' => '/sign-out',
            ],
            'citizen role can access citizen prefix' => [
                'expected' => true,
                'role' => User::ROLE_CITIZEN,
                'url' => '/citizen',
            ],
            'citizen role can NOT access politician prefix' => [
                'expected' => false,
                'role' => User::ROLE_CITIZEN,
                'url' => '/politician',
            ],
            'citizen role can NOT access admin prefix' => [
                'expected' => false,
                'role' => User::ROLE_CITIZEN,
                'url' => '/admin',
            ],
            'politician role can access public prefix' => [
                'expected' => true,
                'role' => User::ROLE_POLITICIAN,
                'url' => '/sign-out',
            ],
            'politician role can access citizen prefix' => [
                'expected' => true,
                'role' => User::ROLE_POLITICIAN,
                'url' => '/citizen',
            ],
            'politician role can access politician prefix' => [
                'expected' => true,
                'role' => User::ROLE_POLITICIAN,
                'url' => '/politician',
            ],
            'politician role can NOT access admin prefix' => [
                'expected' => false,
                'role' => User::ROLE_POLITICIAN,
                'url' => '/admin',
            ],
            'admin role can access public prefix' => [
                'expected' => true,
                'role' => User::ROLE_ADMIN,
                'url' => '/sign-out',
            ],
            'admin role can access citizen prefix' => [
                'expected' => true,
                'role' => User::ROLE_ADMIN,
                'url' => '/citizen',
            ],
            'admin role can access politician prefix' => [
                'expected' => true,
                'role' => User::ROLE_ADMIN,
                'url' => '/politician',
            ],
            'admin role can access admin prefix' => [
                'expected' => true,
                'role' => User::ROLE_ADMIN,
                'url' => '/admin',
            ],
        ];
    }
}
