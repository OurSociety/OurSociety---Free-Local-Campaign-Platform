<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class Leveling extends AbstractMigration
{
    public function up(): void
    {
        $this->table('questions')
            ->addColumn('position', 'integer', ['after' => 'level', 'default' => null, 'null' => true, 'signed' => false])
            ->update();

        $this->table('users')
            ->addColumn('level', 'integer', ['after' => 'role', 'default' => '1', 'null' => false, 'signed' => false])
            ->update();
    }

    public function down(): void
    {
        $this->table('questions')
            ->removeColumn('position')
            ->update();

        $this->table('users')
            ->removeColumn('level')
            ->update();
    }
}
