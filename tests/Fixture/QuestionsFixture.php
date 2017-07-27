<?php
declare(strict_types = 1);

namespace OurSociety\Test\Fixture;

use OurSociety\Model\Entity\Question;
use OurSociety\Model\Table\CategoriesTable;
use OurSociety\TestSuite\Fixture as App;
use OurSociety\Utility\Csv;

/**
 * QuestionsFixture
 *
 */
class QuestionsFixture extends App\TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'category_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'level' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'question' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'type' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'citizen_answer_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'politician_answer_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    public $defaults = [
        'citizen_answer_count' => 0,
        'politician_answer_count' => 0,
    ];

    public function init(): void
    {
        $questions = Csv::fromFile(CONFIG . 'Seeds' . DS . 'questions.csv')->toArray();

        $i = 1;
        collection($questions)->each(function (array $record) use (&$i) {
            $this->records[] = [
                'level' => $i <= 50 ? 1 : 0,
                'category_name' => $record['Type'],
                'question' => $record['Question'],
                'type' => $record['Answer A'] === 'Yes' ? Question::TYPE_BOOL : Question::TYPE_SCALE,
            ];
            $i++;
        });

        parent::init();
    }

    public function _getRecords(): array
    {
        $categoryIds = CategoriesTable::instance()->find()->find('list', [
            'keyField' => 'name',
            'valueField' => 'id'
        ])->orderAsc('name')->toArray();

        if (count($categoryIds) === 0) {
            throw new \RuntimeException('Categories fixture needs loaded before Questions fixture');
        }

        $this->records = collection($this->records)->map(function (array $record) use ($categoryIds) {
            if (!isset($record['category_name'])) {
                return $record;
            }

            $record['category_id'] = $categoryIds[$record['category_name']];
            unset($record['category_name']);

            return $record;
        });

        return parent::_getRecords();
    }
}
