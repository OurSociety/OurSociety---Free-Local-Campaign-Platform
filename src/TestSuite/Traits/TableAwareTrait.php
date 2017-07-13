<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite\Traits;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

/**
 * Trait TableAwareTrait
 *
 * @method static void assertInstanceOf(string $expected, mixed $actual, string $message = '')
 */
trait TableAwareTrait
{

    private function table(string $tableName = null): Table
    {
        $alias = $tableName ?: ($this->tableName ?? null);

        if (!$alias) {
            throw new \InvalidArgumentException('Missing table alias');
        }

        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return TableRegistry::get($alias);
    }

    protected function assertAssociationExists(string $expectedAssociation, string $expectedType): void
    {
        $association = $this->table()->association($expectedAssociation);

        self::assertInstanceOf($expectedType, $association);
    }
}
