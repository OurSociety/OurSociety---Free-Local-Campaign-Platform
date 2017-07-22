<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class CreatePoliticianProfile extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('politician_articles', ['id' => false, 'primary_key' => ['id']]);

        $table
            ->addColumn('id', 'uuid', ['default' => '', 'limit' => null, 'null' => false])
            ->addColumn('politician_id', 'uuid', ['default' => null, 'limit' => null, 'null' => false])
            ->addColumn('slug', 'string', ['default' => '', 'limit' => 255, 'null' => false])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 255, 'null' => false])
            ->addColumn('body', 'text', ['default' => null, 'limit' => null, 'null' => false])
            ->addColumn('version', 'integer', ['default' => null, 'limit' => 11, 'null' => false])
            ->addColumn('approved', 'datetime', ['default' => null, 'limit' => null, 'null' => true])
            ->addColumn('published', 'datetime', ['default' => null, 'limit' => null, 'null' => true])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->create();

        $this->table('politician_awards', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', ['default' => '', 'limit' => null, 'null' => false])
            ->addColumn('politician_id', 'uuid', ['default' => '', 'limit' => null, 'null' => false])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 255, 'null' => false])
            ->addColumn('description', 'text', ['default' => null, 'limit' => null, 'null' => false])
            ->addColumn('obtained', 'date', ['default' => null, 'length' => null, 'null' => false])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->create();

        $this->table('politician_positions', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', ['default' => '', 'limit' => null, 'null' => false])
            ->addColumn('politician_id', 'uuid', ['default' => '', 'limit' => null, 'null' => false])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 255, 'null' => false])
            ->addColumn('company', 'string', ['default' => '', 'limit' => 255, 'null' => false])
            ->addColumn('started', 'date', ['default' => null, 'limit' => null, 'null' => false])
            ->addColumn('ended', 'date', ['default' => null, 'limit' => null, 'null' => true])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->create();

        $this->table('politician_qualifications', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', ['default' => '', 'limit' => null, 'null' => false])
            ->addColumn('politician_id', 'uuid', ['default' => '', 'limit' => null, 'null' => false])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 255, 'null' => false])
            ->addColumn('institution', 'string', ['default' => '', 'limit' => 255, 'null' => false])
            ->addColumn('started', 'date', ['default' => null, 'limit' => null, 'null' => false])
            ->addColumn('ended', 'date', ['default' => null, 'limit' => null, 'null' => true])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->create();

        $this->table('politician_videos', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', ['default' => '', 'limit' => null, 'null' => false])
            ->addColumn('politician_id', 'uuid', ['after' => 'id', 'default' => '', 'length' => null, 'null' => false])
            ->addColumn('youtube_video_id', 'string', ['default' => '', 'limit' => 11, 'null' => false])
            ->addColumn('featured', 'boolean', ['default' => false, 'null' => false, 'after' => 'active'])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->create();

        $this->table('users')
            ->addColumn('picture', 'string', ['default' => null, 'limit' => 255, 'null' => true, 'after' => 'answer_count'])
            ->addColumn('address_1', 'string', ['default' => null, 'limit' => 255, 'null' => true, 'after' => 'picture'])
            ->addColumn('address_2', 'string', ['default' => null, 'limit' => 255, 'null' => true, 'after' => 'address_1'])
            ->addColumn('city', 'string', ['default' => null, 'limit' => 50, 'null' => true, 'after' => 'address_2'])
            ->addColumn('state', 'string', ['default' => null, 'limit' => 2, 'null' => true, 'after' => 'city'])
            ->addColumn('birth_name', 'string', ['default' => null, 'limit' => 255, 'null' => true, 'after' => 'state'])
            ->addColumn('birth_city', 'string', ['default' => null, 'limit' => 50, 'null' => true, 'after' => 'birth_name'])
            ->addColumn('birth_state', 'string', ['default' => null, 'limit' => 2, 'null' => true, 'after' => 'birth_city'])
            ->addColumn('birth_country', 'string', ['default' => null, 'limit' => 50, 'null' => true, 'after' => 'birth_state'])
            ->addColumn('born', 'date', ['default' => null, 'length' => null, 'null' => true, 'after' => 'birth_country'])
            ->update();
    }

    public function down(): void
    {
        $this->dropTable('politician_articles');
        $this->dropTable('politician_awards');
        $this->dropTable('politician_positions');
        $this->dropTable('politician_qualifications');
        $this->dropTable('politician_videos');

        $this->table('users')
            ->removeColumn('picture')
            ->removeColumn('address_1')
            ->removeColumn('address_2')
            ->removeColumn('city')
            ->removeColumn('state')
            ->removeColumn('birth_name')
            ->removeColumn('birth_city')
            ->removeColumn('birth_state')
            ->removeColumn('birth_country')
            ->update();
    }
}
