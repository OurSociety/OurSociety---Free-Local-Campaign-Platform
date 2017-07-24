<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller\Politician\Profile;

use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

/**
 * OurSociety\Controller\Politician\Profile\AwardsController Test Case
 */
class AwardsControllerTest extends IntegrationTestCase
{
    public function testAdd(): void
    {
        $this->auth(UsersFixture::EMAIL_POLITICIAN);
        $this->get('/politician/profile/awards/add');
        $this->assertResponseOk();
        $this->assertResponseContains('Add Award');
        $this->assertResponseContains('Award Title');
        $this->assertResponseContains('Description of Award');
        $this->assertResponseContains('Date Obtained');
        $this->assertResponseContains('Year');
        $this->assertResponseContains('Month');
        $this->assertResponseContains('Save');

        $this->post('/politician/profile/awards/add', [
            'name' => 'Test Award',
            'description' => 'An award for passing the test.',
            'obtained' => ['year' => '2010', 'month' => '01'],
        ]);
        $this->assertResponseSuccess();
        $this->assertRedirect('/politician/profile/awards');
        $this->assertFlash('Successfully created politician award');
    }
}
