<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller\Politician\Profile;

use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

/**
 * OurSociety\Controller\Politician\Profile\QualificationsController Test Case
 */
class QualificationsControllerTest extends IntegrationTestCase
{
    public function testAdd(): void
    {
        $this->auth(UsersFixture::EMAIL_POLITICIAN);
        $this->get('/politician/profile/qualifications/add');
        $this->assertResponseOk();
        $this->assertResponseContains('Add Qualification');
        $this->assertResponseContains('Qualification Title');
        $this->assertResponseContains('Institution Name');
        $this->assertResponseContains('Date Started');
        $this->assertResponseContains('Year');
        $this->assertResponseContains('Month');
        $this->assertResponseContains('Date Ended');
        $this->assertResponseContains('Year');
        $this->assertResponseContains('Month');
        $this->assertResponseContains('Save');

        $this->post('/politician/profile/qualifications/add', [
            'name' => 'Test Qualification',
            'institution' => 'Test Institution',
            'started' => ['year' => '2010', 'month' => '01'],
            'ended' => ['year' => '2015', 'month' => '01'],
        ]);
        $this->assertResponseSuccess();
        $this->assertRedirect('/politician/profile/qualifications');
        $this->assertFlash('Successfully created politician qualification');
    }
}
