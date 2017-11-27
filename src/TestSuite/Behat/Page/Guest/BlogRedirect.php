<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Guest;

use OurSociety\TestSuite\Behat\Page\Page;

class BlogRedirect extends Page
{
    protected function getPath(): string
    {
        return '/blog';
    }

    protected function verifyUrl(array $urlParameters = []): void
    {
        $this->assertRedirect('https://www.oursociety.org/');
    }
}
