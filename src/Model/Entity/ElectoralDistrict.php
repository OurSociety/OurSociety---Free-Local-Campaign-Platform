<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use OurSociety\View\AppView;

/**
 * ElectoralDistrict Entity
 *
 * @property string $id
 * @property string $parent_id
 * @property string $id_ocd
 * @property string $id_local
 * @property string $id_gnis
 * @property string $id_census2010
 * @property string $slug
 * @property string $name
 * @property string $short_name
 * @property string $description
 * @property int $number
 * @property string $type_id
 * @property int $office_count
 * @property int $subdivision_count
 * @property int $sibling_count
 * @property int $citizen_count
 * @property int $politician_count
 * @property int $article_factcheck_count
 * @property int $article_year_count
 * @property string $polygon
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property ElectoralDistrict[] $children
 * @property Contest[] $contests
 * @property Election[] $elections
 * @property DistrictType $district_type
 * @property Office[] offices
 * @property ElectoralDistrict $parent
 * @property Event[] $events
 * @property User $mayor
 * @property Election $upcoming_election
 * @property User[] $community_contributors
 * @property ElectoralDistrict $county
 * @property ElectoralDistrict $state
 * @property Article[] $articles
 * @property User[] $elected_officials
 * @property Video[] $videos
 *
 * @property string $display_name
 */
class ElectoralDistrict extends AppEntity implements SearchableEntity
{
    use Traits\SearchableTrait;

    public function equals(ElectoralDistrict $municipality): bool
    {
        return $this->id === $municipality->id;
    }

    public function getArticlesRoute(): array
    {
        return ['_name' => 'municipality:articles', 'municipality' => $this->slug];
    }

    public function getBrowseRoute(): array
    {
        return ['_name' => 'district', 'district' => 'new-jersey'];
    }

    public function getRoute(): array
    {
        if ($this->district_type->isMunicipality()) {
            return ['_name' => 'municipality', 'municipality' => $this->slug];
        }

        return ['_name' => 'district', 'district' => $this->slug];
    }

    public function hasDescription(): bool
    {
        return $this->description !== null;
    }

    public function isMunicipality()
    {
        return $this->district_type->isMunicipality();
    }

    public function printDistrictType(): string
    {
        return $this->district_type ? $this->district_type->name : __('Unknown District Type');
    }

    public function renderLink(AppView $view, $url = null, ?array $options = null): string
    {
        return $view->Html->link($this->name, $url ?: $this->getRoute(), $options ?? []);
    }

    public function renderMap(AppView $view): string
    {
        if ($this->polygon === null) {
            return '';
        }

        $elementId = sprintf('place-%s', $this->slug);
        $script = <<<JAVASCRIPT
drawMap('${elementId}', null, {$this->polygon})
JAVASCRIPT;

        $mapElement = $view->Html->div('card-img-top map pull-right', '', ['id' => $elementId]);
        $mapScript = $view->Html->scriptBlock($script);

        return $mapElement . $mapScript;
    }

    public function searchableAs(): string
    {
        return 'places';
    }

    public function toSearchableArray(): array
    {
        $tree = [
            'lvl0' => 'United States',
            'lvl1' => 'United States > New Jersey',
            'lvl2' => 'United States > New Jersey > ' . ($this->parent->name ?? 'Unknown'),
        ];

        return [
            'slug' => $this->slug,
            'name' => $this->name,
            'parent' => $this->parent->name ?? null,
            'tree' => $tree,
        ];
    }

    public function getViewRoute(): array
    {
        return ['_name' => 'municipality', 'municipality' => $this->slug];
    }

    public function getEventsIndexRoute(): array
    {
        return ['_name' => 'municipality:events', 'municipality' => $this->slug];
    }

    public function getIcon(): string
    {
        return 'street-view';
    }

    protected function _getName(): ?string
    {
        $name = $this->_properties['name'] ?? null;

        return is_string($name) ? ucwords($name) : $name;
    }

    protected function _getDisplayName(): string
    {
        return $this->short_name ?: preg_replace('/ (borough|county|district|township)$/i', '', $this->name);
    }

    protected function _getLabel(): string
    {
        return $this->_properties['name'] . ($this->parent ? ' (' . $this->parent->name . ')' : '');
    }
}
