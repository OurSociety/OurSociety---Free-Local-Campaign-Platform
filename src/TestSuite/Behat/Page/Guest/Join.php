<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Guest;

use OurSociety\TestSuite\Behat\Page\Page;

class Join extends Page
{
    public function signUp($name, $email, $password)
    {
        $this->fillField('Full name', $name);
        $this->fillField('Email address', $email);
        $this->fillField('Password', $password);
        $this->pressButton('Join OurSociety');
    }

    protected function getPath(): string
    {
        return '/join-oursociety';
    }
}
