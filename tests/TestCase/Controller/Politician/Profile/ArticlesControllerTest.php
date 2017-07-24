<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller\Politician\Profile;

use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

/**
 * OurSociety\Controller\Politician\Profile\ArticlesController Test Case
 */
class ArticlesControllerTest extends IntegrationTestCase
{
    public function testAdd(): void
    {
        $this->auth(UsersFixture::EMAIL_POLITICIAN);
        $this->get('/politician/profile/articles/add');
        $this->assertResponseOk();
        $this->assertResponseContains('Add Article');
        $this->assertResponseContains('Title');
        $this->assertResponseContains('Body');
        $this->assertResponseContains('Published');
        $this->assertResponseContains('Save');

        $this->post('/politician/profile/articles/add', [
            'name' => 'Test Article',
            'body' => 'An article about the test.',
            'published' => true,
        ]);
        $this->assertResponseSuccess();
        $this->assertRedirect('/politician/profile/articles');
        $this->assertFlash('Successfully created politician article');
    }
}
