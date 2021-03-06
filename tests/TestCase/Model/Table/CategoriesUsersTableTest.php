<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use OurSociety\Model\Table\CategoriesUsersTable;

/**
 * OurSociety\Model\Table\CategoriesUsersTable Test Case
 */
class CategoriesUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \OurSociety\Model\Table\CategoriesUsersTable
     */
    public $CategoriesUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.categories_users',
        'app.categories',
        'app.questions',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::exists('CategoriesUsers') ? [] : ['className' => CategoriesUsersTable::class];
        $this->CategoriesUsers = TableRegistry::get('CategoriesUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CategoriesUsers);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
