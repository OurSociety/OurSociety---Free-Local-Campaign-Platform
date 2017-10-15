<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Guest;

use OurSociety\TestSuite\Behat\Page\Page;

class Homepage extends Page
{
    protected function getPath(): string
    {
        return '/';
    }

    protected function verifyUrl(array $urlParameters = []): void
    {
        $this->assertRedirect('/sign-in');
    }
}
