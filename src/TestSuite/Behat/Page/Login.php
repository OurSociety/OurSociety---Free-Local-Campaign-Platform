<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

/**
 * LoginPage.
 */
class Login extends Page
{
    protected $path = '/login';

    public function loginAsAdmin(): void
    {
        $this->loginAs('team@oursociety.org', 'democracy');
    }

    public function loginAsCitizen(): void
    {
        $this->loginAs('citizen@example.net', 'democracy');
    }

    public function loginAsPolitician(): void
    {
        $this->loginAs('politician@example.org', 'democracy');
    }

    public function loginAs(string $email, string $password): void
    {
        $this->open();
        $this->fillField('Email', $email);
        $this->fillField('Password', $password);
        $this->pressButton('Login');
    }
}
