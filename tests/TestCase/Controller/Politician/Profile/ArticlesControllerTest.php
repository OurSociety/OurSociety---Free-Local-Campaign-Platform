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
    /**
     * @dataProvider provideView
     * @param string $id The article ID to view.
     * @param string|null $flash The expected flash message.
     */
    public function testView(string $id, string $flash = null): void
    {
        /** @var PoliticianArticle $article */
        $article = TableRegistry::get('PoliticianArticles')->get($id);

        $this->auth(UsersFixture::EMAIL_POLITICIAN);
        $this->get(sprintf('/politician/profile/articles/view/%s', $article->id));
        $this->assertResponseOk();

        // TODO: Determine why this assertion isn't working when flash messages appear in browser.
        //if ($flash !== null) {
        //    $this->assertFlash($flash);
        //}
    }

    public function provideView(): array
    {
        return [
            'success (active)' => [
                'id' => PoliticianArticlesFixture::ACTIVE_ID,
                'flash' => null,
            ],
            'success (unpublished)' => [
                'id' => PoliticianArticlesFixture::UNPUBLISHED_ID,
                'flash' => 'This article is currently unpublished. Please publish it so it can be viewed by citizens.',
            ],
            'success (unapproved)' => [
                'id' => PoliticianArticlesFixture::UNAPPROVED_ID,
                'flash' => 'This article is currently awaiting moderation. Once approved it will be available to citizens.',
            ],
        ];
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
