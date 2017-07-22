<?php
declare(strict_types = 1);

namespace OurSociety\Test\Fixture;

use OurSociety\TestSuite\Fixture as App;

/**
 * CategoriesUsersFixture
 *
 */
class CategoriesUsersFixture extends App\TestFixture
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
        'user_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'answer_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
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
            'id' => '26e719cb-9840-40b1-bea4-405d0c77814b',
            'category_id' => '517e6a5d-641e-473a-b0ed-17cad51af442',
            'user_id' => '8fdea25c-cd85-4581-9c8d-1e4c87a91d8d',
            'answer_count' => 1,
            'created' => '2017-07-13 06:52:32',
            'modified' => '2017-07-13 06:52:32'
        ],
    ];
}
