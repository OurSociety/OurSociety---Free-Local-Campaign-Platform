<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller\Politician;

use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

/**
 * OurSociety\Controller\Politician\PoliticiansController Test Case
 */
class PoliticiansControllerTest extends IntegrationTestCase
{
    public function testView(): void
    {
        $this->auth(UsersFixture::EMAIL_POLITICIAN);
        $this->get(['_name' => 'politician:profile']);
        $this->assertResponseOk();
        $this->assertResponseContains('Politician Dashboard');
        $this->assertResponseContains('Profile');
        $this->assertResponseContains(UsersFixture::NAME_POLITICIAN);
        $this->assertResponseContains('Getting Started');
        $this->assertResponseContains('Example Profile');
        $this->assertResponseContains('Complete Profile');
        $this->assertResponseContains('Edit Articles');
        $this->assertResponseContains('Edit Profile');
        $this->assertResponseContains('Edit Positions');
        $this->assertResponseContains('Edit Qualifications');
        $this->assertResponseContains('Edit Awards');
        $this->assertResponseContains('100% Value Match');
        $this->markTestIncomplete(); // TODO: More assertions
    }

    public function testEdit(): void
    {
        $this->auth(UsersFixture::EMAIL_POLITICIAN);
        $this->get(['_name' => 'politician:profile:edit', 'slug' => UsersFixture::SLUG_POLITICIAN]);
        $this->assertResponseOk();
        $this->assertResponseContains(UsersFixture::NAME_POLITICIAN);
        $this->markTestIncomplete(); // TODO: More assertions
    }
}
