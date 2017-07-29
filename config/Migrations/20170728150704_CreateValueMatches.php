<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class CreateValueMatches extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $this->table('value_matches', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('citizen_id', 'uuid', ['null' => false])
            ->addColumn('politician_id', 'uuid', ['null' => false])
            ->addColumn('category_id', 'uuid', ['null' => true])
            ->addColumn('true_match_percentage', 'decimal', ['null' => false, 'precision' => 5, 'scale' => 2])
            ->addColumn('match_percentage', 'decimal', ['null' => false, 'precision' => 5, 'scale' => 2])
            ->addColumn('error_percentage', 'decimal', ['null' => false, 'precision' => 5, 'scale' => 2])
            ->addColumn('sample_size', 'integer', ['null' => false, 'signed' => false])
            ->addIndex(['citizen_id', 'politician_id', 'category_id'], ['unique' => true, 'name' => 'UNQ_USERS_CATEGORY'])
            ->create();
    }
}
