<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller\Citizen;

use Cake\ORM\TableRegistry;
use OurSociety\Model\Entity\PoliticianArticle;
use OurSociety\Test\Fixture\PoliticianArticlesFixture;
use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

/**
 * OurSociety\Controller\Citizen\ArticlesController Test Case
 */
class ArticlesControllerTest extends IntegrationTestCase
{
    public function testIndex(): void
    {
        $this->auth(UsersFixture::CITIZEN_EMAIL);
        $this->get([
            '_name' => 'politician:articles',
            'politician' => UsersFixture::POLITICIAN_SLUG,
        ]);
        $this->assertResponseOk();
        $this->assertResponseContains('Articles');
        // TODO: Only if no politician passed in URL
        //$this->assertResponseContains('Politician / Author');
        //$this->assertResponseContains(UsersFixture::NAME_POLITICIAN);
        $this->assertResponseContains('Article Title');
        $this->assertResponseContains('The Long Road Ahead');
        $this->assertResponseContains('Publication Date');
        $this->assertResponseContains('Article Summary');
        $this->assertResponseContains(substr(PoliticianArticlesFixture::BODY_PARAGRAPH, 0, 100));
        $this->assertResponseContains('Page 1 of 1, showing 3 records out of 3 total.');
        $this->assertResponseContains(sprintf(
            'politicians/%s/article/%s',
            UsersFixture::POLITICIAN_SLUG,
            PoliticianArticlesFixture::PUBLISHED_AND_APPROVED_SLUG
        ));
    }

    /**
     * @dataProvider provideView
     * @param string $expected The expected case.
     * @param string $user The logged in user.
     * @param string $articleId The article ID to view.
     */
    public function testView(string $expected, string $user, string $articleId): void
    {
        /** @var PoliticianArticle $article */
        $article = TableRegistry::get('PoliticianArticles')
            ->find()
            ->contain(['Politicians'])
            ->where(['PoliticianArticles.id' => $articleId])
            ->firstOrFail();

        $this->auth($user);
        $this->get([
            '_name' => 'politician:article',
            'politician' => $article->politician->slug,
            'article' => $article->slug,
        ]);

        switch ($expected) {
            case 'success':
                $this->assertResponseOk();
                $this->assertResponseContains('Articles');
                $this->assertResponseContains($article->politician->name);
                $this->assertResponseContains($article->name);
                $this->assertResponseContains($article->body);
                break;
            case 'error':
                $this->assertResponseError();
                break;
            case 'redirect':
                $this->assertResponseSuccess();
                $this->assertRedirect([
                    'prefix' => 'politician/profile',
                    'controller' => 'Articles',
                    'action' => 'view',
                    $article->id,
                ]);
                break;
            default:
                $this->fail('Unexpected case');
                break;
        }
    }

    public function provideView(): array
    {
        return [
            'success (citizen @ published & approved)' => [
                'expected' => 'success',
                'user' => UsersFixture::CITIZEN_EMAIL,
                'article' => PoliticianArticlesFixture::PUBLISHED_AND_APPROVED_ID,
            ],
            'error (citizen @ unpublished)' => [
                'expected' => 'error',
                'user' => UsersFixture::CITIZEN_EMAIL,
                'article' => PoliticianArticlesFixture::UNPUBLISHED_ID,
            ],
            'error (citizen @ unapproved)' => [
                'expected' => 'error',
                'user' => UsersFixture::CITIZEN_EMAIL,
                'article' => PoliticianArticlesFixture::UNAPPROVED_ID,
            ],
            'success (politician @ published & approved)' => [
                'expected' => 'success',
                'user' => UsersFixture::POLITICIAN_EMAIL,
                'article' => PoliticianArticlesFixture::PUBLISHED_AND_APPROVED_ID,
            ],
            'redirect (politician @ unpublished)' => [
                'expected' => 'redirect',
                'user' => UsersFixture::POLITICIAN_EMAIL,
                'article' => PoliticianArticlesFixture::UNPUBLISHED_ID,
            ],
            'redirect (politician @ unapproved)' => [
                'expected' => 'redirect',
                'user' => UsersFixture::POLITICIAN_EMAIL,
                'article' => PoliticianArticlesFixture::UNAPPROVED_ID,
            ],
            'success (admin @ published & approved)' => [
                'expected' => 'success',
                'user' => UsersFixture::ADMIN_EMAIL,
                'article' => PoliticianArticlesFixture::PUBLISHED_AND_APPROVED_ID,
            ],
            'redirect (admin @ unpublished)' => [
                'expected' => 'redirect',
                'user' => UsersFixture::ADMIN_EMAIL,
                'article' => PoliticianArticlesFixture::UNPUBLISHED_ID,
            ],
            'redirect (admin @ unapproved)' => [
                'expected' => 'redirect',
                'user' => UsersFixture::ADMIN_EMAIL,
                'article' => PoliticianArticlesFixture::UNAPPROVED_ID,
            ],
        ];
    }
}
