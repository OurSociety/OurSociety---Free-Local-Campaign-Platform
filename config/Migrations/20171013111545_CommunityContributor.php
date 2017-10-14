<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class CommunityContributor extends AbstractMigration
{
    public function change(): void
    {
        $this->table('users')->renameColumn('pathway_politician', 'community_contributor')->update();
    }
}
