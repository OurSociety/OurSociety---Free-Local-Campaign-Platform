<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller\Citizen;

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
        $this->auth(UsersFixture::EMAIL_CITIZEN);
        $this->get([
            '_name' => 'citizen:politician:articles',
            'politician' => UsersFixture::SLUG_POLITICIAN,
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
            '/citizen/politicians/%s/article/%s',
            UsersFixture::SLUG_POLITICIAN,
            PoliticianArticlesFixture::SLUG
        ));
    }

    public function testView(): void
    {
        $this->auth(UsersFixture::EMAIL_CITIZEN);
        $this->get([
            '_name' => 'citizen:politician:article',
            'politician' => UsersFixture::SLUG_POLITICIAN,
            'article' => PoliticianArticlesFixture::SLUG,
        ]);
        $this->assertResponseOk();
        $this->assertResponseContains('Articles');
        $this->assertResponseContains(UsersFixture::NAME_POLITICIAN);
        $this->assertResponseContains('The Long Road Ahead');
        $this->assertResponseContains(PoliticianArticlesFixture::BODY_PARAGRAPH);
    }
}
