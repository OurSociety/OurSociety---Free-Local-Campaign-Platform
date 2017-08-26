<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class MunicipalProfile extends AbstractMigration
{
    public function up(): void
    {
        $this->table('users')
            ->changeColumn('incumbent', 'boolean', ['default' => null, 'limit' => null, 'null' => true])
            ->update();

        $this->table('article_types', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', ['default' => '', 'limit' => null, 'null' => false])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 10, 'null' => false])
            ->create();

        $this->table('events', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', ['default' => '', 'limit' => null, 'null' => false])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 255, 'null' => false])
            ->addColumn('location', 'string', ['default' => '', 'limit' => 255, 'null' => false])
            ->addColumn('description', 'text', ['default' => null, 'limit' => null, 'null' => false])
            ->addColumn('start', 'datetime', ['default' => null, 'limit' => null, 'null' => false])
            ->addColumn('end', 'datetime', ['default' => null, 'limit' => null, 'null' => true])
            ->addColumn('category_id', 'uuid', ['default' => '', 'limit' => null, 'null' => false])
            ->addColumn('electoral_district_id', 'uuid', ['default' => '', 'limit' => null, 'null' => false])
            ->addColumn('user_id', 'uuid', ['default' => '', 'limit' => null, 'null' => false])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->addColumn('modified', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->create();

        $this->table('office_types', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', ['default' => '', 'limit' => null, 'null' => false])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 50, 'null' => false])
            ->addColumn('is_mayor', 'boolean', ['default' => false, 'limit' => null, 'null' => false])
            ->create();

        $this->table('electoral_districts')
            ->addColumn('description', 'text', ['after' => 'name', 'default' => null, 'length' => null, 'null' => false])
            ->addColumn('county_id', 'uuid', ['after' => 'type_id', 'default' => null, 'length' => null, 'null' => true])
            ->addColumn('state_id', 'uuid', ['after' => 'county_id', 'default' => null, 'length' => null, 'null' => true])
            ->update();

        $this->table('politician_articles')
            ->addColumn('aspect_id', 'uuid', ['after' => 'version', 'default' => null, 'length' => null, 'null' => true])
            ->addColumn('article_type_id', 'uuid', ['after' => 'aspect_id', 'default' => null, 'length' => null, 'null' => true])
            ->addColumn('electoral_district_id', 'uuid', ['after' => 'article_type_id', 'default' => null, 'length' => null, 'null' => true])
            ->update();

        $this->table('politician_videos')
            ->addColumn('electoral_district_id', 'uuid', ['after' => 'politician_id', 'default' => '', 'length' => null, 'null' => true])
            ->update();

        $this->table('users')
            ->addColumn('office_type_id', 'uuid', ['after' => 'position', 'default' => null, 'length' => null, 'null' => true])
            ->addColumn('pathway_politician', 'boolean', ['after' => 'incumbent', 'default' => null, 'length' => null, 'null' => true])
            ->update();
    }

    public function down(): void
    {
        $this->table('electoral_districts')
            ->removeColumn('description')
            ->removeColumn('county_id')
            ->removeColumn('state_id')
            ->update();

        $this->table('politician_articles')
            ->removeColumn('aspect_id')
            ->removeColumn('article_type_id')
            ->removeColumn('electoral_district_id')
            ->update();

        $this->table('politician_videos')
            ->removeColumn('electoral_district_id')
            ->update();

        $this->table('users')
            ->changeColumn('incumbent', 'integer', ['default' => null, 'length' => 3, 'null' => true])
            ->removeColumn('office_type_id')
            ->removeColumn('pathway_politician')
            ->update();

        $this->dropTable('article_types');

        $this->dropTable('events');

        $this->dropTable('office_types');
    }
}
