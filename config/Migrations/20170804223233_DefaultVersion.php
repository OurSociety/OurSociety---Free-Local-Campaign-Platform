<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class DefaultVersion extends AbstractMigration
{
    public function up(): void
    {
        $this->table('politician_articles')
            ->changeColumn('version', 'integer', ['null' => true, 'default' => 1])
            ->update();
    }

    public function down(): void
    {
        $this->table('politician_articles')
            ->changeColumn('version', 'integer', ['null' => false, 'default' => null])
            ->update();
    }
}
