<?php
declare(strict_types = 1);

namespace OurSociety\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestCase;

/**
 * PagesControllerTest class
 */
class PagesControllerTest extends IntegrationTestCase
{
    /**
     * testDisplay method
     *
     * @return void
     */
    public function testDisplay(): void
    {
        $this->get('/');
        $this->assertResponseSuccess();
        $this->assertRedirect('index.html');

        $this->get(['_name' => 'home']);
        $this->assertResponseOk();
        $this->assertResponseContains('OurSociety');
        $this->assertResponseContains('<html lang="en">');
    }

    /**
     * testMultipleGet method
     *
     * @return void
     */
    public function testMultipleGet(): void
    {
        $this->get(['_name' => 'home']);
        $this->assertResponseOk();
        $this->get(['_name' => 'home']);
        $this->assertResponseOk();
    }

    /**
     * Test that missing template renders 404 page in production
     *
     * @return void
     */
    public function testMissingTemplate(): void
    {
        Configure::write('debug', false);
        $this->get('/pages/not_existing');

        $this->assertResponseError();
        $this->assertResponseContains('Error');
    }

    /**
     * Test that missing template in debug mode renders missing_template error page
     *
     * @return void
     */
    public function testMissingTemplateInDebug(): void
    {
        Configure::write('debug', true);
        $this->get('/missing');

        $this->assertResponseFailure();
        $this->assertResponseContains('Missing Template');
        $this->assertResponseContains('Stacktrace');
        $this->assertResponseContains('display.ctp'); // TODO: CrudView reports `display.ctp` instead of `missing.ctp`.
    }

    /**
     * Test directory traversal protection
     *
     * @return void
     */
    public function testDirectoryTraversalProtection(): void
    {
        $this->get('/../Layout/ajax');
        $this->assertResponseCode(403);
        $this->assertResponseContains('Forbidden');
    }
}
