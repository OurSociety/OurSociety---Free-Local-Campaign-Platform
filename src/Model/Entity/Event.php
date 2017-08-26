<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\I18n\FrozenTime as DateTime;
use Cake\I18n\Time;

/**
 * Event Entity
 *
 * @property string $id
 * @property string $name
 * @property string $location
 * @property string $description
 * @property DateTime $start
 * @property DateTime $end
 * @property string $category_id
 * @property string $electoral_district_id
 * @property DateTime $created
 * @property DateTime $modified
 */
class Event extends AppEntity
{
    public static function examples(int $count, array $data = null, ?callable $sort = null): array
    {
        return parent::examples($count, $data, function (self $eventA, self $eventB) {
            return $eventA->start->gt($eventB->start);
        });
    }

    public static function example(array $data = null): self
    {
        $data = ($data ?? []) + [
            'name' => 'Example Event',
            'location' => 'Example Location',
            'start' => Time::now()->addDays(random_int(0, 30))
        ];

        return new self($data);
    }
}
