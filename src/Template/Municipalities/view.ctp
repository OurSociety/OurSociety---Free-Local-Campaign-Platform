<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\ElectoralDistrict $municipality The municipality.
 */
?>

<h1 class="os-title" id="content">
    <?= $municipality->name ?>
    <small class="text-muted">
        <?= $municipality->county ? $municipality->county->name : 'Unknown County' ?>,
        <?= $municipality->state ? $municipality->state->name : 'Unknown State' ?>
    </small>
</h1>

<hr>

<div class="row">
    <div class="col-md-3">
        <?= $this->element('Widgets/MunicipalProfile/mayor', ['mayor' => $municipality->mayor]) ?>
    </div>
    <div class="col-md-9">
        <?= $this->element('Widgets/MunicipalProfile/map', ['municipality' => $municipality]) ?>
        <?= $this->element('Widgets/MunicipalProfile/town_information', ['municipality' => $municipality]) ?>
        <?= $this->element('Widgets/MunicipalProfile/upcoming_election', ['upcomingElection' => $municipality->upcoming_election]) ?>
    </div>
</div>

<hr>

<?= $this->element('Widgets/MunicipalProfile/articles', ['articles' => $municipality->articles]) ?>

<hr>

<div class="row">
    <div class="col">
        <?= $this->element('Widgets/MunicipalProfile/elected_officials', ['electedOfficials' => $municipality->elected_officials]) ?>
    </div>

    <div class="col">
        <?= $this->element('Widgets/MunicipalProfile/videos', ['videos' => $municipality->videos]) ?>

        <hr>

        <?= $this->element('Widgets/MunicipalProfile/events', ['events' => $municipality->events]) ?>
    </div>
</div>

<hr>
<?= $this->element('Widgets/MunicipalProfile/pathway_politicians', ['pathwayPoliticians' => $municipality->pathway_politicians]) ?>
