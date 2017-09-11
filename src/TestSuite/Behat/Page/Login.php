<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;

/**
 * LoginPage.
 */
class Login extends Page
{
    private const LABEL_BUTTON_LOGIN = 'Login';
    private const LOCATOR_FIELD_EMAIL = 'Email';
    private const LOCATOR_FIELD_PASSWORD = 'Password';
    private const VALUE_EMAIL_ADMIN = 'team@oursociety.org';
    private const VALUE_EMAIL_CITIZEN = 'citizen@example.net';
    private const VALUE_EMAIL_POLITICIAN = 'politician@example.org';
    private const VALUE_PASSWORD = 'democracy';

    protected $path = '/login';

    public function loginAsAdmin(): void
    {
        $this->loginAs(self::VALUE_EMAIL_ADMIN, self::VALUE_PASSWORD);
    }

    public function loginAsCitizen(): void
    {
        $this->loginAs(self::VALUE_EMAIL_CITIZEN, self::VALUE_PASSWORD);
    }

    public function loginAsPolitician(): void
    {
        $this->loginAs(self::VALUE_EMAIL_POLITICIAN, self::VALUE_PASSWORD);
    }

    public function loginAs(string $email, string $password): void
    {
        $this->open();
        $this->fillField(self::LOCATOR_FIELD_EMAIL, $email);
        $this->fillField(self::LOCATOR_FIELD_PASSWORD, $password);
        $this->pressButton(self::LABEL_BUTTON_LOGIN);
    }

    public function verifyPage(): void
    {
        $this->assertFieldExists(self::LOCATOR_FIELD_EMAIL);
        $this->assertFieldExists(self::LOCATOR_FIELD_PASSWORD);
    }
}
