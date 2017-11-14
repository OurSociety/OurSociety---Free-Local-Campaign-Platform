<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class RenameActiveVerified extends AbstractMigration
{
    public function up(): void
    {
        $this->table('users')
            ->changeColumn('token', 'string', ['after' => 'incumbent', 'default' => null, 'limit' => 6, 'null' => true])
            ->changeColumn('token_expires', 'datetime', ['after' => 'token', 'default' => null, 'null' => true])
            ->changeColumn('active', 'datetime', ['after' => 'last_seen', 'default' => null, 'null' => true])
            ->renameColumn('active', 'verified')
            ->update();
    }

    public function down(): void
    {
        $this->table('users')
            ->renameColumn('verified', 'active')
            ->changeColumn('token', 'string', ['after' => 'name', 'default' => null, 'limit' => 255, 'null' => true])
            ->changeColumn('token_expires', 'datetime', ['after' => 'token', 'default' => null, 'null' => true])
            ->changeColumn('active', 'datetime', ['after' => 'token_expires', 'default' => null, 'null' => true])
            ->update();
    }
}
