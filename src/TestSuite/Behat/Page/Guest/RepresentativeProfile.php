<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Guest;

use OurSociety\TestSuite\Behat\Page\Common\Profile;

/**
 * Representative profile page.
 */
class RepresentativeProfile extends Profile
{
    public function verifyPage()
    {
        parent::verifyPage();

        $this->assertBreadcrumbsExist([
            'Representatives',
            $this->getRepresentativeName(),
        ]);
    }

    protected function getPath(): string
    {
        return '/representative/{representative}';
    }
}
