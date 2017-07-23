<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller\Politician;

use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;
use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

/**
 * OurSociety\Controller\Politician\PoliticiansController Test Case
 */
class PoliticiansControllerTest extends IntegrationTestCase
{
    public function testView(): void
    {
        $this->auth(UsersFixture::POLITICIAN_EMAIL);
        $this->get(['_name' => 'politician:profile']);
        $this->assertResponseOk();
        $this->assertResponseContains('Politician Dashboard');
        $this->assertResponseContains('Profile');
        $this->assertResponseContains(UsersFixture::POLITICIAN_NAME);
        $this->assertResponseContains('Getting Started');
        $this->assertResponseContains('Example Profile');
        $this->assertResponseContains('Your Profile');
        $this->assertResponseContains('Edit Articles');
        $this->assertResponseContains('Edit Profile');
        $this->assertResponseContains('Edit Positions');
        $this->assertResponseContains('Edit Qualifications');
        $this->assertResponseContains('Edit Awards');
        $this->assertResponseContains('100% Value Match');
        $this->markTestIncomplete(); // TODO: More assertions
    }

    public function testEdit(): void
    {
        $this->auth(UsersFixture::POLITICIAN_EMAIL);
        $this->get(['_name' => 'politician:profile:edit', 'slug' => UsersFixture::POLITICIAN_SLUG]);
        $this->assertResponseOk();
        $this->assertResponseContains(UsersFixture::POLITICIAN_NAME);
        $this->markTestIncomplete(); // TODO: More assertions
    }

    public function testPicture(): void
    {
        $this->auth(UsersFixture::POLITICIAN_EMAIL);

        $this->get(['_name' => 'politician:profile:picture']);
        $this->assertResponseError();

        $this->post(['_name' => 'politician:profile:picture']);
        $this->assertResponseFailure();

        $this->configRequest(['headers' => ['Accept' => 'application/json']]);
        $this->post(['_name' => 'politician:profile:picture']);
        $this->assertResponseOk();
        $this->assertResponseContains('{"success":false,"errors":{"picture":{"_empty":"This field cannot be left empty"}}}');

        $file = new File(WWW_ROOT . 'img' . DIRECTORY_SEPARATOR . 'logo.png');
        self::assertTrue($file->copy(TMP . 'picture.jpg'), 'Could not copy test file for upload.');

        $this->configRequest(['headers' => ['Accept' => 'application/json']]);
        mt_srand(42);
        $this->post(['_name' => 'politician:profile:picture'], ['file' => [
            'name' => 'picture.jpg',
            'type' => 'image/jpeg',
            'size' => $file->size(),
            'tmp_name' => TMP . 'picture.jpg',
            'error' => 0
        ]]);
        mt_srand();
        $this->assertResponseOk();
        $this->assertResponseContains('{"success":true}');

        $expected = 'dc663db3-035c-450e-b46a-d447aebc2c14.jpg';
        $filename = sprintf('%s/upload/profile/picture/%s/%s', rtrim(WWW_ROOT, DS), UsersFixture::POLITICIAN_ID, $expected);
        $file = new File($filename);

        self::assertTrue($file->exists(), sprintf('Uploaded file "%s" does not exist.', $filename));
        self::assertTrue($file->delete(), 'Could not cleanup test file for upload.');
        self::assertEquals($expected, TableRegistry::get('Users')->get(UsersFixture::POLITICIAN_ID)->picture);
    }
}
