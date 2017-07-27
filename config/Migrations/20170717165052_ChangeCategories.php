<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/Seeds/CategoriesSeed.php';

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class ChangeCategories extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('categories');
        $table->addColumn('slug', 'string', ['after' => 'id', 'null' => true, 'default' => null]);
        $table->update();

        $seeder = new CategoriesSeed();
        $seeder->setOutput($this->getOutput());
        $seeder->setAdapter($this->getAdapter());
        $seeder->setInput($this->input);
        $seeder->run();
    }

    public function down(): void
    {
        $table = $this->table('categories');
        $table->removeColumn('slug');
        $table->update();
    }
}
