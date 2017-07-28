<?php
declare(strict_types=1);

use Cake\Utility\Text;
use OurSociety\Migration as App;
use OurSociety\Model\Entity\Question;
use OurSociety\Utility\Csv;

/**
 * Questions seeder.
 *
 * Seeds the `questions` table from the `questions.csv` file.
 */
class QuestionsSeed extends App\AbstractSeed
{
    public function run(): void
    {
        $table = $this->table('questions');
        $abort = $this->assertEmptyTable($table);
        if ($abort) {
            return;
        }

        $categoryIds = [];
        foreach ($table->getAdapter()->fetchAll('SELECT id, name FROM categories') as $row) {
            $categoryIds[$row['name']] = $row['id'];
        }

        $data = [];
        foreach (Csv::fromFile(CONFIG . 'Seeds' . DS . 'questions.csv')->toArray() as $record) {
            $data[] = [
                'id' => Text::uuid(),
                'level' => $record['Level'],
                'question' => $record['Question'],
                'type' => $record['Answer A'] === 'Yes' ? Question::TYPE_BOOL : Question::TYPE_SCALE,
                'category_id' => $categoryIds[$record['Type']],
            ];
        }

        $table->insert($data)->save();
    }
}
