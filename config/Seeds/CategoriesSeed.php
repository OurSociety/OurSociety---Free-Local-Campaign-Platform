<?php
declare(strict_types=1);

use Cake\Utility\Text;
use OurSociety\Migration as App;

/**
 * Categories seeder.
 *
 * Seeds the `categories` table from the `questions.csv` file.
 */
class CategoriesSeed extends App\AbstractSeed
{
    public function run(): void
    {
        $table = $this->table('categories');

        $abort = $this->assertEmptyTable($table);
        if ($abort) {
            $db = $this->getAdapter();
            foreach ($db->fetchAll('SELECT id, name FROM categories WHERE slug IS NULL') as $row) {
                $db->execute(sprintf(
                    "UPDATE categories SET slug = '%s' WHERE id = '%s'",
                    (new \Muffin\Slug\Slugger\CakeSlugger)->slug($row['name']),
                    $row['id']
                ));
            }

            return;
        }

        $categories = [];
        foreach ($this->getCsvRecords('questions.csv') as $record) {
            $name = $record['Type'];
            $slug = (new \Muffin\Slug\Slugger\CakeSlugger)->slug($name);
            $questionCount = isset($categories[$name]['question_count'])
                ? ++$categories[$name]['question_count']
                : 0;

            $categories[$name] = ['name' => $name, 'slug' => $slug, 'question_count' => $questionCount];
        }

        $data = array_values(array_map(function (array $category) {
            return ['id' => Text::uuid()] + $category;
        }, $categories));

        $table->insert($data)->save();
    }
}
