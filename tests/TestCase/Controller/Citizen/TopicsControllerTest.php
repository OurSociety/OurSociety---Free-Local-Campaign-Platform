<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller\Citizen;

use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

/**
 * OurSociety\Controller\Citizen\TopicsController Test Case
 */
class TopicsControllerTest extends IntegrationTestCase
{
    public function testCompare(): void
    {
        $this->auth(UsersFixture::CITIZEN_EMAIL);
        $this->get(['_name' => 'citizen:topics:compare', 'politician' => UsersFixture::POLITICIAN_SLUG]);
        $this->assertResponseOk();
    }
}
