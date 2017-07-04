<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase as TestCase;
use OurSociety\Model\Entity\User;
use OurSociety\Test\Fixture\UsersFixture;

class IntegrationTestCase extends TestCase
{
    use FixturesTrait;

    /**
     * {@inheritdoc}
     */
    public function tearDown(): void
    {
        TableRegistry::clear();
        parent::tearDown();
    }

    /**
     * Authenticates as a particular user.
     *
     * Populates session with the same data as a logged in users would have so
     * tests can simulate a logged in user.
     *
     * @param string|null $email The email address of the user to authenticate as.
     * @param array $userData Extra user data.
     */
    public function auth(string $email = null, array $userData = []): void
    {
        if ($email === null) {
            return;
        }

        /** @var User $user */
        $user = TableRegistry::get('Users')->find('auth')->where(compact('email'))->firstOrFail();
        $this->session(['Auth' => ['User' => $userData + $user->toArray()]]);
    }

    /**
     * Log in as default admin user.
     */
    public function loginAsAdmin(): void
    {
        $this->auth(UsersFixture::EMAIL_ADMIN);
    }

    /**
     * Log in as default citizen user.
     */
    public function loginAsCitizen(): void
    {
        $this->auth(UsersFixture::EMAIL_CITIZEN);
    }

    /**
     * Log in as default politician user.
     */
    public function loginAsPolitician(): void
    {
        $this->auth(UsersFixture::EMAIL_POLITICIAN);
    }

    public function assertRedirectLoginForm(string $redirectUrl = null): void
    {
        $this->assertRedirect(['_name' => 'users:login', '?' => ['redirect' => $redirectUrl]]);
    }
}
