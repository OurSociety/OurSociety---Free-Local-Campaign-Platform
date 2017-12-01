<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class CreateNotifications extends AbstractMigration
{
    public function change(): void
    {
        $this->table('notifications', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', ['default' => null, 'null' => false])
            ->addColumn('user_id', 'uuid', ['default' => null, 'null' => false])
            ->addColumn('title', 'string', ['default' => null, 'limit' => 255, 'null' => false])
            ->addColumn('body', 'text', ['default' => null, 'null' => true])
            ->addColumn('seen', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('created', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->create();

        $this->table('users')
            ->addColumn('unread_notification_count', 'integer', ['null' => false, 'default' => 0, 'signed' => false, 'after' => 'answer_count'])
            ->update();
    }
}
