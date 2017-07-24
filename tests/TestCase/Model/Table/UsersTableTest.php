<?php
declare(strict_types = 1);

namespace OurSociety\Test\TestCase\Model\Table;

use OurSociety\Model\Entity\User;
use OurSociety\TestSuite\Traits\FixturesTrait;

/**
 * OurSociety\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends AppTableTest
{
    use FixturesTrait;

    public function testSave(): void
    {
        $table = self::instance();
        /** @var User $user */
        $user = $table->saveOrFail($table->newEntity([
            'email' => 'test@example.com',
            'zip' => '07501',
            'password' => 'password',
            'name' => 'Test User',
        ]));

        self::assertEquals('test@example.com', $user->email);
        self::assertEquals('07501', $user->zip);
        self::assertNotEquals('password', $user->password);
        self::assertEquals('Test User', $user->name);
    }

    /**
     * {@inheritdoc}
     */
    public function provideValidationDefault(): array
    {
        return array_merge([
            'success (role is admin)' => [
                'field' => 'role',
                'value' => 'admin',
            ],
            'success (role is citizen)' => [
                'field' => 'role',
                'value' => 'citizen',
            ],
            'success (role is politician)' => [
                'field' => 'role',
                'value' => 'politician',
            ],
            'error (role is NOT in list)' => [
                'field' => 'role',
                'value' => 'unknown',
                'error' => ['inList' => 'The only valid roles are "admin", "citizen", "politician".'],
            ],
            'success (zip is valid)' => [
                'field' => 'zip',
                'value' => '01234',
            ],
            'success (zip is extended valid)' => [
                'field' => 'zip',
                'value' => '01234-5678',
            ],
            'error (zip is NOT valid)' => [
                'field' => 'zip',
                'value' => '1234',
                'error' => ['zip' => 'Please enter a valid ZIP code (e.g. 12345 or 12345-6789)'],
            ],
            // TODO: Validate rest of fields.
        ], parent::provideValidationDefault());
    }

    /**
     * {@inheritdoc}
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete();
        parent::testBuildRules(); // TODO: Implement.
    }

    /**
     * Test findAuth method
     *
     * @return void
     */
    public function testFindAuth(): void
    {
        $expected = $this->table->query();
        $actual = $this->table->find('auth');

        self::assertEquals($expected, $actual);
    }
}
