<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class CreateUsers extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('users', ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('slug', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('email', 'string', ['default' => null, 'limit' => 255, 'null' => true])
            ->addColumn('password', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('name', 'string', ['default' => null, 'limit' => 255, 'null' => true])
            ->addColumn('first_name', 'string', ['default' => null, 'limit' => 50, 'null' => true])
            ->addColumn('last_name', 'string', ['default' => null, 'limit' => 50, 'null' => true])
            ->addColumn('token', 'string', ['default' => null, 'limit' => 255, 'null' => true])
            ->addColumn('token_expires', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('api_token', 'string', ['default' => null, 'limit' => 255, 'null' => true])
            ->addColumn('activation_date', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('tos_date', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('active', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('is_superuser', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('role', 'string', ['default' => 'user', 'limit' => 255, 'null' => true])
            ->addColumn('last_seen', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('created', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
