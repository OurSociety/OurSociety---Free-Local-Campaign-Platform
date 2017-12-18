<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Guest;

use OurSociety\TestSuite\Behat\Page\Page;

class ForgotPassword extends Page
{
    protected function getRouteName(): string
    {
        return 'users:forgot';
    }
}
