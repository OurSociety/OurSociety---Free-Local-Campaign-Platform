<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Guest;

use OurSociety\TestSuite\Behat\Page\Page;

class Home extends Page
{
    protected function getRouteName(): string
    {
        return 'home';
    }

    protected function verifyUrl(array $urlParameters = []): void
    {
        $this->assertRedirect('https://www.oursociety.org/');
    }
}
