<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class AddQuestionLevel extends AbstractMigration
{
    public function up(): void
    {
        $this->table('questions')
            ->addColumn('level', 'integer', ['after' => 'category_id', 'default' => '0', 'length' => 4, 'null' => true])
            ->update();
    }

    public function down(): void
    {
        $this->table('questions')
            ->removeColumn('level')
            ->update();
    }
}
