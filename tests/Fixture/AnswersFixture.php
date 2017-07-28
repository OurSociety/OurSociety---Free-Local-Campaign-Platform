<?php
declare(strict_types = 1);

namespace OurSociety\Test\Fixture;

use OurSociety\Model\Entity\Answer;
use OurSociety\TestSuite\Fixture as App;

/**
 * AnswersFixture
 *
 */
class AnswersFixture extends App\TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'question_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'answer' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'importance' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
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

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 'f64e16e5-e5e2-4e59-beab-a3e76ab5f943',
            'question_id' => '4099e304-4c93-4993-b16d-c753a2c7b1f3',
            'user_id' => 'f4e3bed3-3b56-416a-8765-6d90cf9a5409',
            'answer' => Answer::ANSWER_STRONGLY_AGREE,
            'importance' => Answer::IMPORTANCE_VERY,
            'created' => '2017-07-13 17:57:00',
            'modified' => '2017-07-13 17:57:00'
        ],
    ];
}
