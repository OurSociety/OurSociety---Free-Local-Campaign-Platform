<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\ElectoralDistrict $municipality The municipality.
 * @var \OurSociety\Model\Entity\User|null $currentUser The current user, if any.
 */

$this->Breadcrumbs->add('My Municipality')
?>

<div class="row">
    <div class="col">
        <h1 class="os-title" id="content">
            <?= $municipality->display_name ?>
            <small class="text-muted">
                <?= $municipality->county ? $municipality->county->display_name : 'Unknown County' ?>,
                <?= $municipality->state ? $municipality->state->display_name : 'Unknown State' ?>
            </small>
        </h1>
    </div>
    <?php if ($currentUser && $currentUser->canEditMunicipality($municipality)): ?>
        <div class="col-auto">
            <?= $this->Html->link(
                __('Edit Municipal Profile'),
                ['_name' => 'municipality:edit', 'municipality' => $municipality->slug],
                ['class' => ['btn btn-outline-dark'], 'icon' => 'pencil']
            ) ?>
        </div>
    <?php endif ?>
</div>

<hr>

<div class="row">
    <div class="col-md-3">
        <?= $this->element('Widgets/MunicipalProfile/mayor', ['mayor' => $municipality->mayor]) ?>
    </div>
    <div class="col-md-9 d-none d-md-block">
        <?= $this->element('Widgets/MunicipalProfile/map', ['municipality' => $municipality]) ?>
        <?= $this->element('Widgets/MunicipalProfile/town_information', ['municipality' => $municipality]) ?>
        <?= $this->element('Widgets/MunicipalProfile/upcoming_election', ['upcomingElection' => $municipality->upcoming_election]) ?>
    </div>
</div>

<hr>

<?= $this->element('Widgets/MunicipalProfile/stats') ?>

<hr>

<div class="row">
    <div class="col">
        <h2>
            <?= __('Trending Policies, Plans & Values') ?>
        </h2>
    </div>
    <div class="col-auto">
        <div class="btn-group">
            <?= $this->Html->link(
                __('Submit Your Own Idea'),
                ['_name' => 'municipality:article:new', 'municipality' => $municipality->slug],
                ['icon' => 'fire', 'class' => ['btn', 'btn-outline-dark']]
            ) ?>
            <?= $this->Html->link(
                __('View All'),
                ['_name' => 'municipality:articles', 'municipality' => $municipality->slug],
                ['icon' => 'list', 'class' => ['btn', 'btn-outline-dark']]
            ) ?>
            <?php /*
        <div class="btn btn-outline-dark disabled">
            <i class="fa fa-fw fa-fire"></i>
            <?= __('Hot') ?>
        </div>
        <div class="btn btn-outline-dark disabled">
            <i class="fa fa-fw fa-asterisk"></i>
            <?= __('New') ?>
        </div>
        <div class="btn btn-outline-dark disabled">
            <i class="fa fa-fw fa-line-chart"></i>
            <?= __('Top') ?>
        </div>
        */ ?>
        </div>
    </div>
</div>

<?= $this->element('Widgets/MunicipalProfile/articles', ['articles' => $municipality->articles]) ?>

<hr>

<h2 class="mb-3">
    <?= __('Town Commons') ?>
</h2>

<div class="row">
    <div class="col-md-6">
        <?= $this->element('Widgets/MunicipalProfile/elected_officials', ['electedOfficials' => $municipality->elected_officials]) ?>
    </div>

    <div class="col-md-6">
        <?= $this->element('Widgets/MunicipalProfile/videos', ['videos' => $municipality->videos]) ?>



        <?= $this->element('Widgets/MunicipalProfile/events', ['events' => $municipality->events]) ?>
    </div>
</div>

<hr>

<?= $this->element('Widgets/MunicipalProfile/pathway_politicians', ['pathwayPoliticians' => $municipality->pathway_politicians]) ?>
