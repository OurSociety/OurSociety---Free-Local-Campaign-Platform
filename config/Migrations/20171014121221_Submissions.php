<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class Submissions extends AbstractMigration
{
    public function change(): void
    {
        $this->table('submissions', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', ['default' => null, 'null' => false])
            ->addColumn('user_id', 'uuid', ['default' => null, 'null' => false])
            ->addColumn('body', 'text', ['default' => null, 'null' => false])
            ->addColumn('done', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->addColumn('modified', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->create();
    }
}
