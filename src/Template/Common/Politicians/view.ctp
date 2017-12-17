<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Question[]|\Cake\Collection\CollectionInterface $questions
 * @var \OurSociety\Model\Entity\User $politician The currently viewed politician.
 * @var \OurSociety\Model\Entity\User $identity The currently authenticated user.
 * @var \OurSociety\View\Cell\Profile\PictureCell $picture The profile picture cell.
 * @var \OurSociety\View\Cell\Profile\ValueMatchCell $valueMatch The value match cell.
 * @var bool $edit True if editing profile, false otherwise.
 */
?>

<div class="row">
    <div class="col">
        <h2 id="page-title">
            <?= $politician->name ?>
        </h2>
    </div>
    <div class="col-auto">
        <?= $this->fetch('actions_heading') ?>
    </div>
</div>

<hr>

<section>
    <div class="row text-center">
        <div class="col-sm-4">
            <?= $this->element('Widgets/PoliticianProfile/picture') ?>
        </div>
        <div class="col-sm-8">
            <?= $this->element('Widgets/PoliticianProfile/value_match') ?>
        </div>
    </div>
</section>

<hr>

<section>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col">
                    <h3>
                        <?= __('My platform') ?>
                    </h3>
                </div>
                <div class="col-auto">
                    <?= $this->fetch('actions_videos') ?>
                </div>
            </div>
        </div>
        <div class="col text-right">
            <?= $this->fetch('actions_articles') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 text-center">
            <?= $this->element('Widgets/PoliticianProfile/videos') ?>
        </div>
        <div class="col-md-6" id="articles">
            <?= $this->element('Widgets/PoliticianProfile/articles') ?>
        </div>
    </div>
</section>

<hr>

<section>
    <h3>
        <?= __('About {name}', [
            'name' => $this->request->getParam('id') ? $politician->name : __('me'),
        ]) ?>
    </h3>
    <div class="row">
        <div class="col-md-8">
            <?= $this->element('Widgets/PoliticianProfile/positions') ?>
            <?= $this->element('Widgets/PoliticianProfile/qualifications') ?>
            <?= $this->element('Widgets/PoliticianProfile/awards') ?>
        </div>
        <div class="col-md-4">
            <?= $this->element('Widgets/PoliticianProfile/born') ?>
        </div>
    </div>
</section>
