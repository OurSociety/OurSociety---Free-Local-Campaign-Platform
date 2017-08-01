<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite\Fixture;

use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Spatie\DbDumper\Databases\MySql as DatabaseDumper;

class DatabaseFixture
{
    public function loadTestDatabase(): void
    {
        $this->insertDump('test');
    }

    public function dumpFixtureDatabase(): void
    {
        $config = ConnectionManager::get('fixtures')->config();

        DatabaseDumper::create()
            ->setDbName($config['database'])
            ->setUserName($config['username'])
            ->setPassword($config['password'])
            ->dontUseExtendedInserts()
            ->excludeTables(['phinxlog'])
            ->dumpToFile($this->getFixturesDumpFilename());
    }

    public function restoreFixtureDatabase(): void
    {
        $this->insertDump('fixtures');
    }

    private function insertDump(string $connectionName): void
    {
        $dump = new File($this->getFixturesDumpFilename());

        /** @var Connection $connection */
        $connection = ConnectionManager::get($connectionName);
        $connection->query($dump->read());
    }

    private function getFixturesDumpFilename(): string
    {
        return CONFIG . 'Seeds' . DS . 'fixtures.sql';
    }
}
