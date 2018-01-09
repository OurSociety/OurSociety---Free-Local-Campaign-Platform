<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Politician;

use OurSociety\TestSuite\Behat\Page\Page;

class Dashboard extends Page
{
    protected function getRouteName(): string
    {
        return 'politician:dashboard';
    }
}
