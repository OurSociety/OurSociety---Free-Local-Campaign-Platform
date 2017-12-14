<?php
declare(strict_types=1);

namespace OurSociety\ORM;

use Cake\Collection\Collection;
use Cake\Datasource\ConnectionManager;
use Cake\ORM as Cake;
use OurSociety\Model\Table\AppTable;
use RuntimeException;

class TableRegistry extends Cake\TableRegistry
{
    public static function all(array $options = null): Collection
    {
        $options = $options ?? ['connection' => 'default'];
        $connection = ConnectionManager::get($options['connection']);

        if (!method_exists($connection, 'schemaCollection')) {
            throw new RuntimeException(sprintf(
                'The "%s" connection is not compatible with TableRegistry::all() ' .
                'as it does not implement a "schemaCollection()" method.',
                $options['connection']
            ));
        }

        $tableNames = $connection->schemaCollection()->listTables();
        $tableNameBlacklist = ['phinxlog'];

        return collection($tableNames)
            ->filter(function (string $tableName) use ($tableNameBlacklist): bool {
                return in_array($tableName, $tableNameBlacklist, true) === false;
            })->map(function ($tableName): Cake\Table {
                return self::get($tableName);
            });
    }

    public static function get($name, array $options = null): AppTable
    {
        if (isset($options['connection']) && is_string($options['connection'])) {
            $options['connection'] = ConnectionManager::get($options['connection']);
        }

        $table = parent::get($name, $options ?? []);

        if (!$table instanceof AppTable) {
            throw new RuntimeException(sprintf('No table class "%s" in application', $name));
        }

        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return $table;
    }
}
