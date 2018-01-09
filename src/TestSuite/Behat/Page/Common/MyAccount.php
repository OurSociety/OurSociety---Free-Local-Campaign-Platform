<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Common;

use OurSociety\TestSuite\Behat\Page\Page;

/**
 * MyAccount.
 */
class MyAccount extends Page
{
    public function verifyPage()
    {
        $this->assertBreadcrumbExists('My Account');
    }

    protected function getRouteName(): string
    {
        return 'users:profile';
    }
}
