<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class Plans extends AbstractMigration
{

    public function up(): void
    {
        $this->table('users')
            ->addColumn('plan', 'string', ['after' => 'role', 'length' => 20, 'null' => true, 'default' => null])
            ->update();
    }

    public function down(): void
    {
        $this->table('users')
            ->removeColumn('plan')
            ->update();
    }
}

