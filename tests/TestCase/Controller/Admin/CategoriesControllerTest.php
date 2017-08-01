<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller\Admin;

use Cake\ORM\TableRegistry;
use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

/**
 * OurSociety\Controller\Admin\CategoriesController Test Case
 */
class CategoriesControllerTest extends IntegrationTestCase
{
    public $autoFixtures = false;

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->auth(UsersFixture::ADMIN_EMAIL);
        $this->get('/admin/categories');
        $this->assertResponseOk();
        $this->assertResponseContainsTableHeading('Name');
        $this->assertResponseContainsTableHeading('# Questions');
        $this->assertResponseContainsTableHeading('Actions');
        $this->assertResponseNotContainsTableHeading('Id');
        $this->assertResponseNotContainsTableHeading('Created');
        $this->assertResponseNotContainsTableHeading('Modified');
        $this->assertResponseContainsButton('Add');
        $this->assertResponseContainsButton('Edit');
        $this->assertResponseContainsButton('View');
        $this->assertResponseContainsButton('Delete');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->auth(UsersFixture::ADMIN_EMAIL);
        $this->get('/admin/categories/view/' . TableRegistry::get('Categories')->find()->firstOrFail()->id);
        $this->assertResponseOk();
        $this->assertResponseContainsTableHeading('Name');
        $this->assertResponseContainsTableHeading('# Questions');
        $this->assertResponseContainsTableHeading('Created');
        $this->assertResponseContainsTableHeading('Modified');
        //$this->assertResponseNotContainsTableHeading('Id'); // TODO: Relation shows ID
        $this->assertResponseContainsButton('Index');
        $this->assertResponseContainsButton('Add');
        $this->assertResponseContainsButton('Edit');
        $this->assertResponseContainsButton('View');
        $this->assertResponseContainsButton('Delete');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    private function assertResponseContainsButton(string $pattern, ?string $message = null): void
    {
        $this->assertResponseContainsTag('a', $pattern, 'class="btn', $message);
    }

    private function assertResponseContainsTableHeading(string $pattern, ?string $message = null): void
    {
        $this->assertResponseContainsTag('th', $pattern, null, $message);
    }

    private function assertResponseNotContainsTableHeading(string $pattern, ?string $message = null): void
    {
        $this->assertResponseNotContainsTag('th', $pattern, null, $message);
    }

    private function assertResponseContainsTag(string $tag, string $pattern, ?string $attr = null, ?string $message = null): void
    {
        $this->assertResponseRegExp(sprintf('#<%s.*?%s.*?>.*?%s.*?</%s>#s', $tag, $attr, preg_quote($pattern, '#'), $tag), $message);
    }

    private function assertResponseNotContainsTag(string $tag, string $pattern, ?string $attr = null, ?string $message = null): void
    {
        $this->assertResponseNotRegExp(sprintf('#<%s.*?%s.*?>.*?%s.*?</%s>#s', $tag, $attr, preg_quote($pattern, '#'), $tag), $message);
    }
}
