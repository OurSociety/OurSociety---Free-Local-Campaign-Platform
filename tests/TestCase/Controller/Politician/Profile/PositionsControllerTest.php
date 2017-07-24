<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller\Politician\Profile;

use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

/**
 * OurSociety\Controller\Politician\Profile\PositionsController Test Case
 */
class PositionsControllerTest extends IntegrationTestCase
{
    public function testAdd(): void
    {
        $this->auth(UsersFixture::EMAIL_POLITICIAN);
        $this->get('/politician/profile/positions/add');
        $this->assertResponseOk();
        $this->assertResponseContains('Add Position');
        $this->assertResponseContains('Position Title');
        $this->assertResponseContains('Company Name');
        $this->assertResponseContains('Date Started');
        $this->assertResponseContains('Year');
        $this->assertResponseContains('Month');
        $this->assertResponseContains('Date Ended');
        $this->assertResponseContains('Year');
        $this->assertResponseContains('Month');
        $this->assertResponseContains('Save');

        $this->post('/politician/profile/positions/add', [
            'name' => 'Test Position',
            'company' => 'Test Company',
            'started' => ['year' => '2010', 'month' => '01'],
            'ended' => ['year' => '2015', 'month' => '01'],
        ]);
        $this->assertResponseSuccess();
        $this->assertRedirect('/politician/profile/positions');
        $this->assertFlash('Successfully created politician position');
    }
}
