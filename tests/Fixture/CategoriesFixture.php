<?php
declare(strict_types = 1);

namespace OurSociety\Test\Fixture;

use OurSociety\TestSuite\Fixture as App;
use OurSociety\Utility\Csv;

/**
 * CategoriesFixture
 *
 */
class CategoriesFixture extends App\TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'slug' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'question_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
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

    //public $defaults = [
        //'citizen_answer_count' => 0,
        //'politician_answer_count' => 0,
    //];

    public function init(): void
    {
        collection(Csv::fromFile(CONFIG . 'Seeds' . DS . 'questions.csv')->toArray())
            ->each(function (array $record) {
                $name = $record['Type'];
                $this->records[$name] = [
                    'name' => $name,
                    'question_count' => isset($this->records[$name]['question_count'])
                        ? ++$this->records[$name]['question_count']
                        : 0,
                ];
            });

        parent::init();
    }
}
