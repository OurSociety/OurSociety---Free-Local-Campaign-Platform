<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase as TestCase;
use OurSociety\Model\Entity\User;

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
    protected function auth(string $email = null, array $userData = []): void
    {
        if ($email === null) {
            return;
        }

        /** @var User $user */
        $user = TableRegistry::get('Users')->find('auth')->where(compact('email'))->firstOrFail();
        $this->session(['Auth' => ['User' => $userData + $user->toArray()]]);
    }

    /**
     * Assert email body.
     *
     * @param string $name The expected name of the user.
     * @param string $body The expected email body.
     * @return void
     */
    protected function assertEmailBody(string $name, string $body): void
    {
        $template = <<<EMAIL
Hi ${name},

${body}

Thank you,

OurSociety Team
EMAIL;

        $this->assertEmailContains($template);
    }

    /**
     * Assert email contains.
     *
     * @param string $string The expected string for email to contain.
     * @return void
     */
    protected function assertEmailContains(string $string): void
    {
        self::assertContains(str_replace("\n", "\r\n", $string), Configure::read('EmailTransport.test.message'));
    }

    /**
     * Assert email to.
     *
     * @param string $email The expected To: email address.
     * @return void
     */
    protected function assertEmailTo(string $email): void
    {
        $this->assertEmailHeader('To', $email);
    }

    /**
     * Assert email header.
     *
     * @param string $header The email header name.
     * @param string $value The expected email header value.
     * @return void
     */
    protected function assertEmailHeader(string $header, string $value): void
    {
        self::assertContains(sprintf("%s: %s\r\n", $header, $value), Configure::read('EmailTransport.test.headers'));
    }

    /**
     * Assert email subject.
     *
     * @param string $subject The expected email subject.
     * @return void
     */
    protected function assertEmailSubject(string $subject): void
    {
        $this->assertEmailHeader('Subject', $subject);
    }

    /**
     * Assert flash.
     *
     * Checks that a flash message exists in the session.
     *
     * @param string $expected The expected flash message.
     * @return void
     */
    protected function assertFlash(string $expected): void
    {
        $key = 'Flash.flash.0.message';
        $this->assertSession($expected, $key, sprintf('Found "%s"', $this->_requestSession->read($key)));
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
