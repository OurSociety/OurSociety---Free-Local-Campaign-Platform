<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

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

    private function assertAssociationExists(string $expectedAssociation, string $expectedType): void
    {
        $association = $this->table()->association($expectedAssociation);
        self::assertInstanceOf($expectedType, $association);
    }
}
