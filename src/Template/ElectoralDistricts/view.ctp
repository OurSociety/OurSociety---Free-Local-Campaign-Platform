<?php
declare(strict_types=1);

use OurSociety\Model\Entity\ElectoralDistrict;

/**
 * View an electoral district as a guest.
 *
 * @var \OurSociety\View\AppView $this
 * @var ElectoralDistrict $electoralDistrict
 */

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

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" integrity="sha512-M2wvCLH6DSRazYeZRIm1JnYyh22purTM+FDB5CsyxtQJYeKq83arPe5wgbNmcFXGqiSH2XR8dT/fJISVA1r/zQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js" integrity="sha512-lInM/apFSqyy1o6s89K4iQUKg6ppXEgsVxT35HbzUupEVRh2Eu9Wdl4tHj7dZO0s1uvplcYGmt3498TtHq+log==" crossorigin=""></script>
    <style>
        .map {
            width: 300px;
            height: 170px;
        }
    </style>
    <script>
        drawMap = function(id, municipalityData, zipData) {
            var map = L.map(id, { attributionControl: false }).setView([40.0583, -74.4057], 6);

            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 18,
                attribution: '',
                //attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
                //'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                //'Imagery © <a href="http://mapbox.com">Mapbox</a>',
                id: 'mapbox.light'
            }).addTo(map);

            if (municipalityData) {
                var municipalityLayer = L.geoJSON(municipalityData);
                municipalityLayer.addTo(map);
                map.fitBounds(municipalityLayer.getBounds());
            }

            if (zipData) {
                var zipLayer = L.geoJSON(zipData, {style:  {
                    "color": "#ff7800",
                    "weight": 5,
                    "opacity": 0.65
                }});
                zipLayer.addTo(map);
                //if (!municipalityData) {
                map.fitBounds(zipLayer.getBounds());
                //}
            }
        };
    </script>







    <ol class="breadcrumb">
        <li>Electoral Districts</li>
        <?php if ($electoralDistrict->parent !== null): ?>
            <li><?= $this->Html->link($electoralDistrict->parent->name, [
                    '_name' => 'district',
                    'district' => $electoralDistrict->parent->slug,
                ]) ?></li>
        <?php endif ?>
        <li><?= $electoralDistrict->name ?></li>
    </ol>

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

    <h2>
        <?= \Cake\Utility\Inflector::humanize($electoralDistrict->district_type->name) ?>
        <span class="small text-muted">District Type</span>
    </h2>

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

    <h3>Subdivisions</h3>

    <p>This district contains the following districts:</p>

    <?php foreach ($childrenByType as $districtTypeName => $children): ?>
        <h4><?= $districtTypeName ?></h4>
        <ul>
            <?php foreach ($children as $child): ?>
                <li><?= $child->renderSummaryElement($this) ?></li>
            <?php endforeach ?>
        </ul>
    <?php endforeach ?>

<?php endif ?>
