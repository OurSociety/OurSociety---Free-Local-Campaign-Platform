<?php
declare(strict_types = 1);

namespace OurSociety\Test\TestCase\Controller\Admin;

use Cake\ORM\TableRegistry;
use OurSociety\Model\Entity\User;
use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

class UsersControllerTest extends IntegrationTestCase
{
    public function testIndex(): void
    {
        $this->auth(UsersFixture::EMAIL_ADMIN);
        $this->get('/admin/users');
        $this->assertResponseOk();
        $this->assertResponseContains('Users');
        $this->assertResponseContains('Add');
        $this->assertResponseNotContains('Id');
        $this->assertResponseContains('Name');
        $this->assertResponseContains('Email');
        $this->assertResponseNotContains('Password');
        $this->assertResponseContains('Active');
        $this->assertResponseContains('Created');
        $this->assertResponseContains('Modified');
        $this->assertResponseContains('Edit');
        $this->assertResponseContains('View');
        $this->assertResponseContains('Delete'); // TODO: Implement soft-delete w/ undo
        //$this->assertResponseContains('Change Password'); // TODO: Implement change password action
        collection((new UsersFixture)->records)
            ->each(function (array $record) {
                $this->assertResponseContains($record['name']);
                $this->assertResponseContains($record['email']);
                // TODO: Fix timestamp columns
                //$this->assertResponseContains($record['created']);
                //$this->assertResponseContains($record['modified']);
            });
        $this->assertResponseContains('Page 1 of 1, showing 3 records out of 3 total.');
    }

    public function testAdd(): void
    {
        $this->auth(UsersFixture::EMAIL_ADMIN);
        $this->get('/admin/users/add');
        $this->assertResponseContains('Add User');
        $this->assertResponseContains('Index');
        $this->assertResponseNotContains('Id');
        $this->assertResponseContains('Name');
        $this->assertResponseContains('Email');
        $this->assertResponseNotContains('Password'); // TODO: Generate and email a random password.
        $this->assertResponseContains('Active');
        // TODO: Fix timestamp columns
        $this->assertResponseNotContains('Created');
        $this->assertResponseNotContains('Modified');
        $this->assertResponseContains('Save');
        $this->assertResponseContains('Save & continue editing');
        $this->assertResponseContains('Save & create new');
        $this->assertResponseContains('Back');

        $this->post('/admin/users/add', [
            '_method' => 'POST',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'active' => true,
        ]);
        $this->assertResponseSuccess();
        //$this->assertResponseNotContains('Could not create user'); // Fix validation issue.
        //$this->assertResponseCode(302);
        //$this->assertRedirect(sprintf('/admin/users/view/%s', $user->id));
    }

    public function testEdit(): void
    {
        /** @var User $user */
        $user = TableRegistry::get('Users')->find()->where(['email' => UsersFixture::EMAIL_ADMIN])->firstOrFail();

        $this->auth(UsersFixture::EMAIL_ADMIN);
        $this->get(sprintf('/admin/users/edit/%s', $user->id));
        $this->assertResponseContains(sprintf('Edit User: %s', $user->name)); // Remove ID from heading
        $this->assertResponseContains('Index');
        $this->assertResponseContains('Add');
        $this->assertResponseContains('View');
        $this->assertResponseContains('Delete');
        $this->assertResponseNotContains('Id');
        $this->assertResponseContains('Name');
        $this->assertResponseContains('Email');
        $this->assertResponseNotContains('Password'); // TODO: Generate and email password reset link.
        $this->assertResponseContains('Active');
        // TODO: Fix timestamp columns
        $this->assertResponseNotContains('Created');
        $this->assertResponseNotContains('Modified');
        $this->assertResponseContains('Save');
        $this->assertResponseContains('Save & continue editing');
        $this->assertResponseContains('Save & create new');
        $this->assertResponseContains('Back');

        //debug($user->id);
        $this->post(sprintf('/admin/users/edit/%s', $user->id), [
            '_method' => 'PUT',
            'id' => $user->id,
            'name' => 'Augustus O. Bacon',
            'email' => 'politician@example.org',
            'active' => true,
            '_save' => '',
        ]);
        $this->assertResponseSuccess();
        //$this->assertResponseNotContains('Could not update user'); // Fix validation issue.
        //$this->assertResponseCode(302);
        //$this->assertRedirect(sprintf('/admin/users/view/%s', $user->id));
    }

    public function testDelete(): void
    {
        $userQuery = TableRegistry::get('Users')->find()->where(['email' => UsersFixture::EMAIL_ADMIN]);

        /** @var User $user */
        $user = $userQuery->firstOrFail();

        $this->auth(UsersFixture::EMAIL_ADMIN);
        $this->post(sprintf('/admin/users/view/%s', $user->id), [
            '_method' => 'DELETE',
            'name' => 'Augustus O. Bacon',
            'email' => 'politician@example.org',
            'active' => true,
        ]);
        $this->assertResponseSuccess();
        //$this->assertResponseCode(302); // Fix DELETE request.
        //$this->assertRedirect('/admin/users/index');
        //
        //$this->expectException(RecordNotFoundException::class);
        //$userQuery->firstOrFail();
    }

    public function testView(): void
    {
        /** @var User $user */
        $user = TableRegistry::get('Users')->find()->where(['email' => UsersFixture::EMAIL_ADMIN])->firstOrFail();

        $this->auth(UsersFixture::EMAIL_ADMIN);
        $this->get(sprintf('/admin/users/view/%s', $user->id)); // TODO: Don't use UUID in URLs.
        $this->assertResponseOk();
        $this->assertResponseContains(sprintf('View User: %s', $user->name));
        $this->assertResponseContains('Index');
        $this->assertResponseContains('Add');
        $this->assertResponseContains('Edit');
        $this->assertResponseContains('Delete');
        $this->assertResponseNotContains('Id');
        $this->assertResponseContains('Name');
        $this->assertResponseContains($user->name);
        $this->assertResponseContains($user->email);
        $this->assertResponseNotContains($user->password);
        $this->assertResponseContains('Active');
        // TODO: Fix timestamp columns
        //$this->assertResponseContains((string)$user->created);
        //$this->assertResponseContains((string)$user->modified);
    }
}
