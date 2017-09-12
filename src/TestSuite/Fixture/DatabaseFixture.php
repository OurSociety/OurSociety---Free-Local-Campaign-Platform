<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite\Fixture;

use Cake\Database\Connection;
use Cake\Database\Statement\MysqlStatement;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Spatie\DbDumper\Databases\MySql as DatabaseDumper;

class DatabaseFixture
{
    private const CONNECTION_TEST = 'test';
    private const CONNECTION_FIXTURES = 'fixtures';

    public function loadTestDatabase(): void
    {
        $connection = $this->getConnection(self::CONNECTION_TEST);
        $this->dropTables($connection);
        $this->importDump($connection);
    }

    public function dumpFixtureDatabase(): void
    {
        $connection = $this->getConnection(self::CONNECTION_FIXTURES);
        $config = $connection->config();
        $filename = $this->getFixturesDumpFilename();

        DatabaseDumper::create()
            ->setDbName($config['database'])
            ->setUserName($config['username'])
            ->setPassword($config['password'])
            ->dontUseExtendedInserts()
            ->dumpToFile($filename);

        file_put_contents($filename, str_replace('`polygon` varchar(255) ', '`polygon` geometry ', file_get_contents($filename)));
    }

    public function restoreFixtureDatabase(): void
    {
        /** @var Connection $connection */
        $connection = $this->getConnection(self::CONNECTION_FIXTURES);
        $this->dropTables($connection);
        $this->importDump($connection);
    }

    private function dropTables(Connection $connection): void
    {
        /** @var MysqlStatement $statement */
        /** @noinspection SqlResolve */
        $sql = \sprintf("SELECT * FROM information_schema.tables WHERE table_schema = '%s';", $connection->config()['database']);
        $statement = $connection->query($sql);
        $rows = $statement->fetchAll('assoc');
        if (count($rows) === 0) {
            return;
        }

        $dropStatements = \implode("\n", \collection($rows)->map(function ($row): string {
            return \str_replace('?', $row['TABLE_NAME'], 'DROP TABLE IF EXISTS ?;');
        })->toArray());
        $connection->query($dropStatements);
    }

    private function getConnection($name): Connection
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return ConnectionManager::get($name);
    }

    private function getFixturesDumpFilename(): string
    {
        return CONFIG . 'Seeds' . DS . 'fixtures.sql';
    }

    private function importDump(Connection $connection): void
    {
        $dump = new File($this->getFixturesDumpFilename());

        /** @var MysqlStatement $statement */
        $statement = $connection->prepare($dump->read());
        $statement->bufferResults(false);
        $result = $statement->execute();
        if ($result === false) {
            throw new \PDOException($statement->errorInfo());
        }
    }
}
