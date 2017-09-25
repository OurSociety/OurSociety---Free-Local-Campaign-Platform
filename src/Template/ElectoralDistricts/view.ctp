<?php
declare(strict_types=1);

use Cake\Utility\Inflector;
use OurSociety\Model\Entity\ElectoralDistrict;

/**
 * View an electoral district as a guest.
 *
 * @var \OurSociety\View\AppView $this
 * @var ElectoralDistrict $electoralDistrict
 */

$this->Breadcrumbs->add(__('Browse Places'));
if ($electoralDistrict->parent !== null):
    $this->Breadcrumbs->add($electoralDistrict->parent->name, [
        '_name' => 'district',
        'district' => $electoralDistrict->parent->slug,
    ]);
endif;
$this->Breadcrumbs->add($electoralDistrict->name);

/**
 * Group by type.
 *
 * @param ElectoralDistrict $child The individual electoral district to group by type.
 * @return string The name of the type to group by.
 */
$groupByType = function (ElectoralDistrict $child): string {
    return $child->district_type ? $child->district_type->name : 'Unknown District Type';
};

/** @var ElectoralDistrict[][] $childrenByType */
$childrenByType = collection($electoralDistrict->children)->groupBy($groupByType);
?>

<?= $this->element('map') ?>

<div class="pull-right">
    <p class="small text-right text-muted">
        OCD ID: <?= $electoralDistrict->id_ocd ?>
    </p>
    <?php if ($electoralDistrict->polygon): ?>
        <div id="zip" class="map pull-right"></div>
        <script>
            drawMap('zip', null, <?= $electoralDistrict->polygon ?>)
        </script>
    <?php endif ?>
</div>

<h1>
    <?= $electoralDistrict->name ?>
    <small class="text-muted">
        <?= $electoralDistrict->district_type->name ?>
    </small>
</h1>

<?php if ($electoralDistrict->parent !== null): ?>
    <p>
        <?= __('{electoral_district} is one of {sibling_count} districts in the {parent_electoral_district} area.', [
            'electoral_district' => $electoralDistrict->name,
            'sibling_count' => $electoralDistrict->sibling_count ?: 'many',
            'parent_electoral_district' => $electoralDistrict->parent->renderLink($this),
        ]) ?>
    </p>
<?php endif ?>

<p>
    <?= $electoralDistrict->district_type->description ?>
</p>

<?php if ($electoralDistrict->offices): ?>

    <h3>Offices</h3>

    <p>This district contains the following offices:</p>

    <ul>
        <?php foreach ($electoralDistrict->offices as $office): ?>
            <li><?= $office->renderSummaryElement($this) ?></li>
        <?php endforeach ?>
    </ul>

<?php endif ?>

<?php if ($electoralDistrict->contests): ?>

    <h3>Contests</h3>

    <p>This district contains the following election contests:</p>

    <ul>
        <?php foreach ($electoralDistrict->contests as $child): ?>
            <li><?= $child->renderSummaryElement($this) ?></li>
        <?php endforeach ?>
    </ul>

<?php endif ?>

<?php if ($electoralDistrict->children): ?>
    <?php foreach ($childrenByType as $districtTypeName => $children): ?>
        <h3><?= Inflector::pluralize($districtTypeName) ?></h3>
        <div class="card-deck mb-3">
        <?php $i = 1; foreach ($children as $child): ?>
            <?= $child->renderCardElement($this) ?>
            <?php if ($i % 3 === 0): ?>
        </div>
        <div class="card-deck mb-3">
            <?php endif ?>
            <?php $i++; endforeach ?>
        </div>
    <?php endforeach ?>
<?php endif ?>
