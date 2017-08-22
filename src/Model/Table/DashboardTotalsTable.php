<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;

class DashboardTotalsTable
{
    public static function getRows(string $name, string $period): array
    {
        /** @var Connection $connection */
        $connection = ConnectionManager::get('default');
        $sqlFilename = CONFIG . 'Queries' . DS . 'Dashboards' . DS . $name . '_by_' . $period . '.sql';
        $query = file_get_contents($sqlFilename);
        /** @var \PDOStatement $statement */
        $statement = $connection->execute($query);

        return $statement->fetchAll('assoc');
    }
}
