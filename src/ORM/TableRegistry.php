<?php
declare(strict_types=1);

namespace OurSociety\ORM;

use Cake\Collection\Collection;
use Cake\Datasource\ConnectionManager;
use Cake\ORM as Cake;
use \RuntimeException;

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

        return collection($tableNames)->map(function ($tableName): Cake\Table {
            return self::get($tableName);
        });
    }

    public static function get($name, array $options = null)
    {
        if (is_string($options['connection'])) {
            $options['connection'] = ConnectionManager::get($options['connection']);
        }

        return parent::get($name, $options);
    }
}
