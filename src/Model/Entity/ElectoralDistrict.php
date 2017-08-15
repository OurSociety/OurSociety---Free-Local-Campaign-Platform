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
 */
class ElectoralDistrict extends AppEntity
{
    public function renderLink(AppView $view, $url = null): string
    {
        return $view->Html->link($this->name, $url ?: ['_name' => 'district', 'district' => $this->slug]);
    }
}
