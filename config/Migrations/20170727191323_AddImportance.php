<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class AddImportance extends AbstractMigration
{
    public function up(): void
    {
        $this->table('answers')
            ->changeColumn('answer', 'integer', ['default' => null, 'null' => false, 'signed' => true])
            ->addColumn('importance', 'integer', ['default' => null, 'null' => false, 'signed' => true, 'after' => 'answer'])
            ->update();
    }

    public function down(): void
    {
        $this->table('answers')
            ->changeColumn('answer', 'string', ['limit' => 10, 'null' => false])
            ->removeColumn('importance')
            ->update();
    }
}
