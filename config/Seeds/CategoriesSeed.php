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
        $this->assertEmptyTable($table);

        $categories = [];
        foreach ($this->getCsvRecords('questions.csv') as $record) {
            $name = $record['Type'];
            $categories[$name] = [
                'name' => $name,
                'question_count' => isset($categories[$name]['question_count'])
                    ? ++$categories[$name]['question_count']
                    : 0,
            ];
        }

        $data = array_values(array_map(function (array $category) {
            return ['id' => Text::uuid()] + $category;
        }, $categories));

        $table->insert($data)->save();
    }
}
