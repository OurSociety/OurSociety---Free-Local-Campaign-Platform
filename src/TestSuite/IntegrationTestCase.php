<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase as TestCase;
use OurSociety\Model\Entity\User;

class IntegrationTestCase extends TestCase
{
    use Traits\FixturesTrait;
    use Traits\IntegrationAssertionsTrait;
    use Traits\AssertionsTrait;

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
    protected function auth(string $email = null, array $userData = []): void
    {
        if ($email === null) {
            return;
        }

        /** @var User $user */
        $user = TableRegistry::get('Users')->find('auth')->where(compact('email'))->firstOrFail();

        foreach ($userData as $field => $value) {
            $user->{$field} = $value;
        }

        $this->session(['Auth' => ['User' => $user]]);
    }

    /**
     * Resume session.
     *
     * Copies the session from the last request to the next request. This allows integration tests to keep the same
     * session over multiple requests - for example, to remain authenticated or see a flash message.
     *
     * @return void
     */
    protected function resumeSession(): void
    {
        $authenticatedSession = (array)$this->_requestSession->read();
        $this->session($authenticatedSession);
    }
}
