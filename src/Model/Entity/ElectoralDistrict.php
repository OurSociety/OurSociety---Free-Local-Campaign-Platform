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
 * @property User[] $pathway_politicians
 * @property ElectoralDistrict $county
 * @property ElectoralDistrict $state
 * @property PoliticianArticle[] $articles
 * @property User[] $elected_officials
 * @property PoliticianVideo[] $videos
 *
 * @property string $display_name
 */
class ElectoralDistrict extends AppEntity
{
    public function renderLink(AppView $view, $url = null): string
    {
        return $view->Html->link($this->name, $url ?: ['_name' => 'district', 'district' => $this->slug]);
    }

    public function isMunicipality()
    {
        return $this->district_type->isMunicipality();
    }

    protected function _getDisplayName(): string
    {
        return $this->short_name ?: preg_replace('/ (borough|county|district|township)$/i', '', $this->name);
    }

    protected function _getLabel(): string
    {
        return $this->_properties['name'] .
            ($this->parent ? ' (' . $this->parent->name . ')' : '');
    }
}
