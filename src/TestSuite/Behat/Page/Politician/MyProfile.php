<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Politician;

use OurSociety\TestSuite\Behat\Page\Common\Profile;

/**
 * Representatives own profile.
 */
class MyProfile extends Profile
{
    public function verifyPage()
    {
        parent::verifyPage();

        $this->assertBreadcrumbsExist([
            'My Dashboard',
            'My Profile',
        ]);
    }

    protected function getRouteName(): string
    {
        return 'politician:profile';
    }
}
