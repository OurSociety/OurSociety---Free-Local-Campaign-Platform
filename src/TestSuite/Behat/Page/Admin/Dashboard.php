<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Admin;

use OurSociety\TestSuite\Behat\Page\Page;

class Dashboard extends Page
{
    protected function getRouteName(): string
    {
        return 'admin:users:dashboard';
    }
}
