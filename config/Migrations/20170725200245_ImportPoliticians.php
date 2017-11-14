<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class ImportPoliticians extends AbstractMigration
{
    public function up(): void
    {
        $this->table('users')
            ->addColumn('email_temp', 'string', ['after' => 'email', 'default' => null, 'length' => 255, 'null' => true])
            ->addColumn('position', 'string', ['after' => 'born', 'default' => null, 'length' => 50, 'null' => true])
            ->addColumn('incumbent', 'integer', ['after' => 'position', 'default' => null, 'length' => 3, 'null' => true])
            ->update();
    }

    public function down(): void
    {
        $this->table('users')
            ->removeColumn('email_temp')
            ->removeColumn('position')
            ->removeColumn('incumbent')
            ->update();
    }
}
