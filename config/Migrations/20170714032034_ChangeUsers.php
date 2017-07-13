<?php
declare(strict_types=1);

use Migrations\AbstractMigration;
use OurSociety\Model\Entity\User;

/** @noinspection AutoloadingIssuesInspection */
class ChangeUsers extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('users');

        $table
            ->changeColumn('role', 'string', ['default' => User::ROLE_CITIZEN, 'limit' => 10, 'null' => false])
            ->changeColumn('last_seen', 'datetime', ['null' => true, 'default' => null])
            ->removeColumn('first_name')
            ->removeColumn('last_name')
            ->removeColumn('api_token')
            ->removeColumn('activation_date')
            ->removeColumn('tos_date')
            ->removeColumn('is_superuser')
            ->addIndex('email', ['type' => 'unique', 'name' => 'UNQ_USER_EMAIL'])
            ->update();

        $table
            ->addColumn('active_datetime', 'datetime', ['default' => null, 'null' => true, 'after' => 'active'])
            ->update();

        /** @noinspection SqlResolve */
        $table->getAdapter()->execute('UPDATE users SET active_datetime = IF(active = TRUE, CURRENT_TIMESTAMP, null) WHERE 1 = 1');

        $table
            ->removeColumn('active')
            ->renameColumn('active_datetime', 'active')
            ->update();
    }

    public function down(): void
    {
        $table = $this->table('users');
        $table
            ->changeColumn('role', 'string', ['default' => 'user', 'limit' => 255, 'null' => true])
            ->changeColumn('last_seen', 'datetime', ['null' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('first_name', 'string', ['default' => null, 'limit' => 50, 'null' => true, 'after' => 'name'])
            ->addColumn('last_name', 'string', ['default' => null, 'limit' => 50, 'null' => true, 'after' => 'first_name'])
            ->addColumn('api_token', 'string', ['default' => null, 'limit' => 255, 'null' => true, 'after' => 'token_expires'])
            ->addColumn('activation_date', 'datetime', ['default' => null, 'null' => true, 'after' => 'api_token'])
            ->addColumn('tos_date', 'datetime', ['default' => null, 'null' => true, 'after' => 'activation_date'])
            ->addColumn('is_superuser', 'boolean', ['default' => false, 'null' => false, 'after' => 'active'])
            ->removeIndex(['email'])
            ->update();

        $table
            ->addColumn('active_bool', 'boolean', ['default' => false, 'null' => false, 'after' => 'active'])
            ->update();

        /** @noinspection SqlResolve */
        $table->getAdapter()->execute('UPDATE users SET active_bool = (active IS NOT NULL) WHERE 1 = 1');

        $table
            ->removeColumn('active')
            ->renameColumn('active_bool', 'active')
            ->update();
    }
}
