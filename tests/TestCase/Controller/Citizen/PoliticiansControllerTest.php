<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller\Citizen;

use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

/**
 * OurSociety\Controller\Citizen\PoliticiansController Test Case
 */
class PoliticiansControllerTest extends IntegrationTestCase
{
    public function testIndex(): void
    {
        $this->auth(UsersFixture::EMAIL_CITIZEN);
        $this->get(['_name' => 'citizen:politicians']);
        $this->assertResponseOk();
        $this->assertResponseContains(UsersFixture::NAME_POLITICIAN);
    }

    public function testView(): void
    {
        $this->auth(UsersFixture::EMAIL_CITIZEN);
        $this->get(['_name' => 'citizen:politicians:view', 'slug' => UsersFixture::SLUG_POLITICIAN]);
        $this->assertResponseOk();
        $this->assertResponseContains(UsersFixture::NAME_POLITICIAN);
    }
}
