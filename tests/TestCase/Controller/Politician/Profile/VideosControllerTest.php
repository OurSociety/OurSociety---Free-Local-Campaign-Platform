<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller\Politician\Profile;

use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

/**
 * OurSociety\Controller\Politician\Profile\VideosController Test Case
 */
class VideosControllerTest extends IntegrationTestCase
{
    public function testAdd(): void
    {
        $this->auth(UsersFixture::EMAIL_POLITICIAN);
        $this->get('/politician/profile/videos/add');
        $this->assertResponseOk();
        $this->assertResponseContains('Add Video');
        $this->assertResponseContains('YouTube Video ID');
        $this->assertResponseContains('Feature This Video?');
        $this->assertResponseContains('Save');

        $this->post('/politician/profile/videos/add', [
            'youtube_video_id' => 'W7NNOfkcKRg',
            'featured' => true,
        ]);
        $this->assertResponseSuccess();
        $this->assertRedirect('/politician/profile/videos');
        $this->assertFlash('Successfully created politician video');
    }
}
