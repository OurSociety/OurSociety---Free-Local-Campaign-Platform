<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Guest;

use OurSociety\TestSuite\Behat\Page\Page;

class SignIn extends Page
{
    private const LABEL_BUTTON_LOGIN = 'Sign In';
    private const LOCATOR_FIELD_EMAIL = 'email';
    private const LOCATOR_FIELD_PASSWORD = 'password';
    private const VALUE_EMAIL_ADMIN = 'team@oursociety.org';
    private const VALUE_EMAIL_CITIZEN = 'citizen@example.net';
    private const VALUE_EMAIL_POLITICIAN = 'politician@example.org';
    private const VALUE_PASSWORD = 'democracy';

    public function loginAsAdmin(): void
    {
        $this->signInAs(self::VALUE_EMAIL_ADMIN, self::VALUE_PASSWORD);
    }

    public function loginAsCitizen(): void
    {
        $this->signInAs(self::VALUE_EMAIL_CITIZEN, self::VALUE_PASSWORD);
    }

    public function loginAsPolitician(): void
    {
        $this->signInAs(self::VALUE_EMAIL_POLITICIAN, self::VALUE_PASSWORD);
    }

    public function signInAs(string $email, string $password): void
    {
        $this->fillField(self::LOCATOR_FIELD_EMAIL, $email);
        $this->fillField(self::LOCATOR_FIELD_PASSWORD, $password);
        $this->pressButton(self::LABEL_BUTTON_LOGIN);
    }

    public function verifyPage(): void
    {
        //$this->assertFieldExists(self::LOCATOR_FIELD_EMAIL);
        //$this->assertFieldExists(self::LOCATOR_FIELD_PASSWORD);
    }

    public function join(): void
    {
        $this->clickLink('Join OurSociety');
    }

    public function forgotPassword(): void
    {
        $this->clickLink('Forgot password?');
    }

    public function keepMeSignedIn(): void
    {
        // no-op
    }

    public function doNotKeepMeSignedIn(): void
    {
        $this->find('css', '.custom-checkbox')->click();
    }

    public function isRememberMeCookieSet(): void
    {
        $cookie = $this->getDriver()->getCookie('remember_me');

        if ($cookie === null) {
            throw new \Exception('Expected remember me cookie to be set.');
        }
    }

    protected function getPath(): string
    {
        return '/sign-in';
    }
}
