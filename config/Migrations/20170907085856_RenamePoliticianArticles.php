<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class RenamePoliticianArticles extends AbstractMigration
{
    public function up(): void
    {
        $this->table('electoral_districts')
            ->addColumn('short_name', 'string', [
                'after' => 'name',
                'comment' => 'A shorter name to display where there are space constraints (e.g. New Jersey => NJ)',
                'default' => null,
                'length' => 50,
                'null' => true,
            ])
            ->update();

        $this->execute("
            UPDATE electoral_districts 
            SET short_name = 'NJ' 
            WHERE id_ocd = 'ocd-division/country:us/state:nj'
        ");

        $this->table('politician_articles')->rename('articles');
    }

    public function down(): void
    {
        $this->table('electoral_districts')
            ->removeColumn('short_name')
            ->update();

        $this->table('articles')->rename('politician_articles');
    }
}
