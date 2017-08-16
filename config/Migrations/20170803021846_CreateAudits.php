<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class CreateAudits extends AbstractMigration
{
    public function change(): void
    {
        $this->table('audits', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', ['default' => null, 'null' => false])
            ->addColumn('created', 'datetime', ['default' => null, 'null' => false])
            ->addColumn('type', 'string', ['default' => null, 'limit' => 10, 'null' => false])
            ->addColumn('source_key', 'uuid', ['default' => null, 'null' => false])
            ->addColumn('source', 'string', ['default' => null, 'limit' => 50, 'null' => false])
            ->addColumn('parent_source', 'string', ['default' => null, 'limit' => 50, 'null' => true])
            ->addColumn('original', 'text', ['default' => null, 'null' => true])
            ->addColumn('changed', 'text', ['default' => null, 'null' => true])
            ->addColumn('meta', 'text', ['default' => null, 'null' => true])
            ->create();
    }
}
