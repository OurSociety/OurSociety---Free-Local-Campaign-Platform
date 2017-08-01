<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Model\Table;

use ArrayObject;
use Cake\Event\Event;
use Cake\Utility\Hash;
use OurSociety\Model\Table\ValueMatchesTable;
use OurSociety\Test\Fixture\CategoriesFixture;
use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\Traits\FixturesTrait;
use OurSociety\TestSuite\Traits\SnapshotTrait;

/**
 * @property ValueMatchesTable $table
 */
class ValueMatchesTableTest extends AppTableTest
{
    use FixturesTrait;
    use SnapshotTrait;

    public function testBeforeMarshal(): void
    {
        /** @var Event|\PHPUnit_Framework_MockObject_MockObject $event */
        $event = $this->createMock(Event::class);
        /** @var ArrayObject|\PHPUnit_Framework_MockObject_MockObject $options */
        $options = $this->createMock(ArrayObject::class);

        $data = new ArrayObject(['sample_size' => 4, 'match_percentage' => 75]);
        $this->table->beforeMarshal($event, $data, $options);

        self::assertEquals(25, $data['error_percentage']); // 1 / sample_size * 100 = 1 / 4 * 100 = 25
        self::assertEquals(50, $data['true_match_percentage']); // match_percentage - error_percentage = 75 - 25 = 50
    }

    /**
     * @dataProvider provideAfterSave
     * @param array $entities The entities to trigger afterSave with.
     * @return void
     */
    public function testAfterSave(array $entities): void
    {
        $getRecords = function () {
            return $this->table->find()->orderAsc('category_id')->all()->indexBy('id')->toArray();
        };

        $before = $getRecords();
        mt_srand(SEED);
        foreach ($entities as $entity) {
            $this->table->saveOrFail($this->table->newEntity($entity));
        }
        mt_srand();
        $after = $getRecords();

        $this->assertSnapshot(Hash::diff($after, $before));
    }

    public function provideAfterSave(): array
    {
        return [
            'success (creates new total)' => [
                'data' => [
                    [
                        'citizen_id' => UsersFixture::CITIZEN_2_ID,
                        'politician_id' => UsersFixture::POLITICIAN_ID,
                        'category_id' => CategoriesFixture::ID_ANIMALS,
                        'match_percentage' => 100,
                        'sample_size' => 4,
                    ],
                ],
            ],
            'success (updates existing total)' => [
                'data' => [
                    [
                        'citizen_id' => UsersFixture::CITIZEN_1_ID,
                        'politician_id' => UsersFixture::POLITICIAN_ID,
                        'category_id' => CategoriesFixture::ID_ANIMALS,
                        'match_percentage' => 100,
                        'sample_size' => 4,
                    ],
                ],
            ],
            'success (total is average of categories)' => [
                'data' => [
                    [
                        'citizen_id' => UsersFixture::CITIZEN_2_ID,
                        'politician_id' => UsersFixture::POLITICIAN_ID,
                        'category_id' => CategoriesFixture::ID_ANIMALS,
                        'match_percentage' => 100,
                        'sample_size' => 4,
                    ],
                    [
                        'citizen_id' => UsersFixture::CITIZEN_2_ID,
                        'politician_id' => UsersFixture::POLITICIAN_ID,
                        'category_id' => CategoriesFixture::ID_COMMERCE,
                        'match_percentage' => 80,
                        'sample_size' => 5,
                    ],
                ],
            ],
        ];
    }
}
