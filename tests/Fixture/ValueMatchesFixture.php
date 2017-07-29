<?php
namespace OurSociety\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ValueMatchesFixture
 *
 */
class ValueMatchesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'citizen_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'politician_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'category_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'true_match_percentage' => ['type' => 'decimal', 'length' => 5, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'match_percentage' => ['type' => 'decimal', 'length' => 5, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'error_percentage' => ['type' => 'decimal', 'length' => 5, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'sample_size' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
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
            'id' => 'c218c9c7-f4b7-4999-9698-3d46c57db7c3',
            'citizen_id' => '25905564-5af4-4ea0-859f-fca28b98f757',
            'politician_id' => '108003dd-9354-4593-acff-dd3d3808bcfd',
            'category_id' => '7e8a5a2a-c4f2-4599-bdf8-26b9a4b6b9aa',
            'true_match_percentage' => 1.5,
            'match_percentage' => 1.5,
            'error_percentage' => 1.5,
            'sample_size' => 1
        ],
    ];
}
