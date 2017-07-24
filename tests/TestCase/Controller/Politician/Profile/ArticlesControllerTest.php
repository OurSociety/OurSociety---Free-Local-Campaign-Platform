<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller\Politician\Profile;

use Cake\ORM\TableRegistry;
use OurSociety\Model\Entity\PoliticianArticle;
use OurSociety\Test\Fixture\PoliticianArticlesFixture;
use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

/**
 * OurSociety\Controller\Politician\Profile\ArticlesController Test Case
 */
class ArticlesControllerTest extends IntegrationTestCase
{
    public function testView(): void
    {
        /** @var PoliticianArticle $article */
        $article = TableRegistry::get('Users')
            ->find()
            ->where(['slug' => PoliticianArticlesFixture::ACTIVE_SLUG])
            ->firstOrFail();

        $this->auth(UsersFixture::EMAIL_POLITICIAN);
        $this->get(sprintf('/politician/profile/article/%s', $article->slug));
        $this->assertResponseOk();
    }

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
