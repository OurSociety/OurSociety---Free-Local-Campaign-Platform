<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller\Politician\Profile;

use OurSociety\Model\Entity\PoliticianArticle;
use OurSociety\Model\Table\PoliticianArticlesTable;
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
        $article = $this->table()->get($id);

        $this->auth(UsersFixture::POLITICIAN_EMAIL);
        $this->enableRetainFlashMessages();
        $this->get(sprintf('/politician/profile/articles/view/%s', $article->id));
        $this->assertResponseOk();
        if ($flash !== null) {
            $this->assertFlash($flash);
        }
    }

    public function provideView(): array
    {
        return [
            'success (approved and published)' => [
                'id' => PoliticianArticlesFixture::PUBLISHED_AND_APPROVED_ID,
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
        $this->auth(UsersFixture::POLITICIAN_EMAIL);
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
            'published' => false,
        ]);
        $this->assertResponseSuccess();
        $this->assertRedirect('/politician/profile/articles');
        $this->assertFlash('Successfully created politician article');
    }

    public function testEdit(): void
    {
        $article = $this->table()->get(PoliticianArticlesFixture::UNPUBLISHED_ID);

        $this->auth(UsersFixture::POLITICIAN_EMAIL);
        $this->get(sprintf('/politician/profile/articles/edit/%s', $article->id));
        $this->assertResponseOk();
        $this->assertResponseContains('Edit Article');
        $this->assertResponseContains('Title');
        $this->assertResponseContains('Body');
        $this->assertResponseContains('Published');
        $this->assertResponseContains('Save');

        $this->post(sprintf('/politician/profile/articles/edit/%s', $article->id), [
            'name' => 'Test Edit Article',
            'body' => 'An article about the edit test.',
            'published' => true,
        ]);
        $this->assertResponseSuccess();
        $this->assertRedirect('/politician/profile/articles');
        $this->assertFlash('Successfully updated politician article');

        $this->get(sprintf('/politician/profile/articles/view/%s', $article->id));
        $this->assertResponseContains('Test Edit Article');
        $this->assertResponseContains('An article about the edit test.');
    }

    private function table(): PoliticianArticlesTable
    {
        return PoliticianArticlesTable::instance();
    }
}
