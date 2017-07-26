<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite\Traits;

use Cake\Core\Configure;

/**
 * Email assertions.
 *
 * Assertions that are related to testing the test email transport.
 *
 * @method static void assertContains(mixed $needle, mixed $haystack, string $message = '')
 */
trait EmailAssertionsTrait
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
        $actual = Configure::read('EmailTransport.test.message');
        // TODO: This should be in UsersControllerTest::testForgot()
        $actual = preg_replace('/\d{6}/', '{TOKEN}', $actual);

        self::assertContains(str_replace("\n", "\r\n", $string), $actual);
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
}
