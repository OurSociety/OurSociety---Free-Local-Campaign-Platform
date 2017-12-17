<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class RenamePoliticianTables extends AbstractMigration
{
    public function change(): void
    {
        $this->table('politician_awards')->rename('awards');
        $this->table('politician_positions')->rename('positions');
        $this->table('politician_qualifications')->rename('qualifications');
        $this->table('politician_videos')->rename('videos');
    }
}
