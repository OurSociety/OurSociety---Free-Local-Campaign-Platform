<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class Tokens extends AbstractMigration
{
    public function change(): void
    {
        $this->table('tokens', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', ['default' => null, 'null' => false])
            ->addColumn('user_id', 'uuid', ['default' => null, 'null' => false])
            ->addColumn('lookup', 'string', ['limit' => 12, 'default' => null, 'null' => false])
            ->addColumn('hash', 'string', ['limit' => 64, 'default' => null, 'null' => false])
            ->addColumn('expires', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('created', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
