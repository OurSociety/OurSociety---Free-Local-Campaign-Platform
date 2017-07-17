<?php
declare(strict_types = 1);

namespace OurSociety\Test\TestCase\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;
use OurSociety\TestSuite\TestCase;

/**
 * OurSociety\Model\Table\AppTable Test Case
 */
abstract class AppTableTest extends TestCase
{
    //use FixturesTrait;

    /**
     * Test subject
     *
     * @var Table
     */
    public $table;

    protected static function instance(): Table
    {
        $tableClass = preg_replace('#^(.*\\\\)Test\\\\TestCase\\\\(.*)Test$#', '$1$2', static::class);

        return $tableClass::instance();
    }

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->table = static::instance();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->table);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @dataProvider provideValidationDefault
     * @param string $field The name of the field.
     * @param mixed $value The value to set the field.
     * @param array $error The expected error(s) for the field.
     */
    public function testValidationDefault(string $field, $value, array $error = []): void
    {
        $entity = $this->table->newEntity([$field => $value]);
        $actual = $entity->getError($field);

        self::assertEquals($error, $actual);
    }

    /**
     * Base data provider for `testValidationDefault` test.
     *
     * Child classes should override this function and merge their table-specific validation data with these defaults.
     *
     * @return array[]
     */
    public function provideValidationDefault(): array
    {
        return [
            'success (id is uuid)' => [
                'field' => 'id',
                'value' => Text::uuid(),
            ],
            'error (id is NOT uuid)' => [
                'field' => 'id',
                'value' => 123,
                'error' => ['uuid' => 'The provided value is invalid'],
            ],
            // TODO: Breaks registration
            //'success (slug is NOT required)' => [
            //    'field' => 'slug',
            //    'value' => null,
            //],
            'success (slug is string)' => [
                'field' => 'slug',
                'value' => 'slug',
            ],
        ];
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
