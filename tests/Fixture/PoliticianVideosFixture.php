<?php
declare(strict_types=1);

namespace OurSociety\Test\Fixture;

use OurSociety\TestSuite\Fixture as App;

/**
 * PoliticianVideosFixture
 *
 */
class PoliticianVideosFixture extends App\TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'politician_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'youtube_video_id' => ['type' => 'string', 'length' => 11, 'null' => false, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'featured' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    public $defaults = [
        'featured' => false,
    ];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'politician_id' => UsersFixture::ID_POLITICIAN,
            'youtube_video_id' => 'W7NNOfkcKRg',
            'featured' => true,
        ],
        [
            'politician_id' => UsersFixture::ID_POLITICIAN,
            'youtube_video_id' => 'VtVuY3vlnzE',
        ],
        [
            'politician_id' => UsersFixture::ID_POLITICIAN,
            'youtube_video_id' => 'mKGvpF2zTXA',
        ],
        [
            'politician_id' => UsersFixture::ID_POLITICIAN,
            'youtube_video_id' => 'WGi9z6UdlUU',
        ],
        [
            'politician_id' => UsersFixture::ID_POLITICIAN,
            'youtube_video_id' => '6DLQ_fyFkzA',
        ],
        [
            'politician_id' => UsersFixture::ID_POLITICIAN,
            'youtube_video_id' => '9AJz3quMPsA',
        ],
        [
            'politician_id' => UsersFixture::ID_POLITICIAN,
            'youtube_video_id' => 'S_mCWnDCSY8',
        ],
    ];
}
