<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite\Traits;

use Cake\Core\Configure;
use Cake\Network\Session;

/**
 * Integration assertions.
 *
 * Assertions that can only be used in integration tests because they rely on session/etc.
 */
trait IntegrationAssertionsTrait
{
    /**
     * Assert email body.
     *
     * @param string $name The expected name of the user.
     * @param string $body The expected email body.
     * @return void
     */
    protected static function assertEmailBody(string $name, string $body): void
    {
        $template = <<<EMAIL
Hi ${name},

${body}

Thank you,

OurSociety Team
EMAIL;

        self::assertEmailContains($template);
    }

    /**
     * Assert email contains.
     *
     * @param string $string The expected string for email to contain.
     * @return void
     */
    protected static function assertEmailContains(string $string): void
    {
        self::assertContains(str_replace("\n", "\r\n", $string), Configure::read('EmailTransport.test.message'));
    }

    /**
     * Assert email to.
     *
     * @param string $email The expected To: email address.
     * @return void
     */
    protected static function assertEmailTo(string $email): void
    {
        self::assertEmailHeader('To', $email);
    }

    /**
     * Assert email header.
     *
     * @param string $header The email header name.
     * @param string $value The expected email header value.
     * @return void
     */
    protected static function assertEmailHeader(string $header, string $value): void
    {
        self::assertContains(sprintf("%s: %s\r\n", $header, $value), Configure::read('EmailTransport.test.headers'));
    }

    /**
     * Assert email subject.
     *
     * @param string $subject The expected email subject.
     * @return void
     */
    protected static function assertEmailSubject(string $subject): void
    {
        self::assertEmailHeader('Subject', $subject);
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
        /** @var Session $session */
        $session = $this->_requestSession;
        $key = 'Flash.flash.0.message';

        $this->assertSession($expected, $key, sprintf('Found "%s"', $session->read($key)));
    }
}
