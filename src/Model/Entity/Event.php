<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\I18n\FrozenTime as DateTime;
use Cake\I18n\Time;
use OurSociety\View\AppView;

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
 *
 * @property ElectoralDistrict $electoral_district
 * @property bool $is_example True if entity is example.
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
            'start' => Time::now()->addDays(random_int(0, 30)),
            'is_example' => true,
        ];

        return new self($data);
    }

    /**
     * Render link to event.
     *
     * @param AppView $view The view.
     * @param string|array|null $url The url (if overridden).
     * @return string The HTML link.
     */
    public function renderMunicipalViewLink(AppView $view, $url = null): string
    {
        if ($this->is_example) {
            return $this->name;
        }

        return $view->Html->link($this->name, [
            '_name' => 'municipality:event',
            'event' => $this->id,
            'municipality' => $this->electoral_district->slug,
        ]);
    }
}
