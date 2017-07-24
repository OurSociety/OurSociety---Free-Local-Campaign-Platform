<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class ChangeZip extends AbstractMigration
{
    public function up(): void
    {
        $this->table('users')->changeColumn('zip', 'string', ['limit' => 10, 'null' => true]);
    }

    public function down(): void
    {
        // No rolling back as it truncates ZIP code data (e.g. (string)"07501-1234" => (int)75011234)
    }
}
