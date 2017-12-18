<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Guest;

use OurSociety\TestSuite\Behat\Page\Page;

/**
 * MunicipalProfilePage.
 */
class MunicipalProfile extends Page
{
    public function hasMayor(string $name, string $email): bool
    {
        return false;
    }

    public function verifyPage()
    {
        $this->assertHeadingExists('Town information');
    }

    protected function getRouteName(): string
    {
        return 'municipality';
    }
}
