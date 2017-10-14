<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class Reports extends AbstractMigration
{
    public function change(): void
    {
        $this->table('reports', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', ['default' => null, 'null' => false])
            ->addColumn('question_id', 'uuid', ['default' => null, 'null' => false])
            ->addColumn('user_id', 'uuid', ['default' => null, 'null' => false])
            ->addColumn('body', 'text', ['default' => null, 'null' => false])
            ->addColumn('done', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->addColumn('modified', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->create();
    }
}
