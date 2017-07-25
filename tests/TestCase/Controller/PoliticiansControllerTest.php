<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller;

use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

/**
 * OurSociety\Controller\Citizen\PoliticiansController Test Case
 */
class PoliticiansControllerTest extends IntegrationTestCase
{
    public function testIndex(): void
    {
        $this->get(['_name' => 'politicians']);
        $this->assertResponseOk();
        $this->assertResponseContains(UsersFixture::NAME_POLITICIAN);
    }

    public function testView(): void
    {
        $this->get(['_name' => 'politicians:view', 'politician' => UsersFixture::SLUG_POLITICIAN]);
        $this->assertResponseOk();
        $this->assertResponseContains(UsersFixture::NAME_POLITICIAN);
    }

    public function testViewClaim(): void
    {
        $this->get(['_name' => 'politicians:view', 'politician' => 'imported-politician']);
        $this->assertResponseOk();
        $this->assertResponseContains('Imported Politician');
        $this->assertResponseContains('Claim Your Profile');
        $this->assertResponseContains('/politicians/imported-politician/claim');
    }
}
