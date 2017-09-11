<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class PathwayPolitician extends AbstractMigration
{
    public function up(): void
    {
        $this->table('electoral_districts')
            ->addColumn('article_factcheck_count', 'integer', ['default' => 0, 'null' => false, 'after' => 'state_id'])
            ->addColumn('article_year_count', 'integer', ['default' => 0, 'null' => false, 'after' => 'article_factcheck_count'])
            ->addColumn('citizen_count', 'integer', ['default' => 0, 'null' => false, 'after' => 'article_year_count'])
            ->changeColumn('office_count', 'integer', ['default' => 0, 'null' => false])
            ->addColumn('politician_count', 'integer', ['default' => 0, 'null' => false, 'after' => 'office_count'])
            ->changeColumn('subdivision_count', 'integer', ['default' => 0, 'null' => false])
            ->changeColumn('sibling_count', 'integer', ['default' => 0, 'null' => false])
            ->update();
    }

    public function down(): void
    {
        $this->table('electoral_districts')
            ->removeColumn('article_factcheck_count')
            ->removeColumn('article_year_count')
            ->removeColumn('citizen_count')
            ->changeColumn('office_count', 'integer', ['default' => null, 'null' => true])
            ->removeColumn('politician_count')
            ->changeColumn('subdivision_count', 'integer', ['default' => null, 'null' => true])
            ->changeColumn('sibling_count', 'integer', ['default' => null, 'null' => true])
            ->update();
    }
}
