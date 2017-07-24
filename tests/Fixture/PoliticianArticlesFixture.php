<?php
declare(strict_types=1);

namespace OurSociety\Test\Fixture;

use OurSociety\TestSuite\Fixture as App;

/**
 * PoliticianArticlesFixture
 *
 */
class PoliticianArticlesFixture extends App\TestFixture
{
    const BODY_PARAGRAPH = <<<HTML
<p>
    Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit
    nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa
    neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc
    mattis convallis.
</p>

HTML;
    const ACTIVE_ID = 'approved_and_published';
    const ACTIVE_SLUG = 'the-long-road-ahead';
    const UNPUBLISHED_ID = 'unpublished';
    const UNAPPROVED_ID = 'unapproved';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'politician_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'slug' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'body' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'version' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'approved' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'published' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
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
            'id' => self::ACTIVE_ID,
            'politician_id' => UsersFixture::ID_POLITICIAN,
            'slug' => self::ACTIVE_SLUG,
            'name' => 'The Long Road Ahead',
            'version' => 2,
            'approved' => '2017-07-11 10:00:00',
            'published' => '2017-07-10 20:00:00',
        ],
        [
            'politician_id' => UsersFixture::ID_POLITICIAN,
            'slug' => self::ACTIVE_SLUG, // need an identifier that matches new version
            'name' => 'The Long Road Ahead (old version)',
            'version' => 1,
            'approved' => '2017-07-08 16:00:00',
            'published' => '2017-07-08 14:00:00',
        ],
        [
            'politician_id' => UsersFixture::ID_POLITICIAN,
            'name' => 'The Previous Election',
            'version' => 1,
            'approved' => '2017-06-21 10:00:00',
            'published' => '2017-06-20 20:00:00',
        ],
        [
            'politician_id' => UsersFixture::ID_POLITICIAN,
            'name' => 'Vote The Future',
            'version' => 2,
            'approved' => '2017-05-04 10:00:00',
            'published' => '2017-05-03 20:00:00',
        ],
        [
            'id' => self::UNAPPROVED_ID,
            'politician_id' => UsersFixture::ID_POLITICIAN,
            'name' => 'Published Article (Not Approved)',
            'version' => 1,
            'approved' => null,
            'published' => '2017-05-01 20:00:00',
        ],
        [
            'id' => self::UNPUBLISHED_ID,
            'politician_id' => UsersFixture::ID_POLITICIAN,
            'name' => 'Approved Article (Not Published)',
            'version' => 1,
            'approved' => '2017-05-02 10:00:00',
            'published' => null,
        ],
    ];

    public function init(): void
    {
        parent::init();

        $setBody = function (array $record) {
            $record['body'] = str_repeat(self::BODY_PARAGRAPH, 10);

            return $record;
        };

        $this->records = collection($this->records)
            ->map($setBody)
            ->toArray();
    }
}
