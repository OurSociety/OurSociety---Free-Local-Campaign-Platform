<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User[] $politicians The list of politicians.
 */

$this->Breadcrumbs->add('Browse Politicians');
?>

<h2><?= __('Politicians') ?></h2>

<hr>

<section class="row">
    <?php foreach ($politicians as $politician): ?>
        <div class="col-md-6">
            <div class="media">
                <div class="media-left">
                    <?= $this->Html->politicianLink(
                        $politician,
                        $this->Html->jdenticon($politician->slug, [
                            'class' => ['media-object'],
                            'alt' => __('Profile picture of {politician_name}', ['politician_name' => $politician->name]),
                            'height' => '150',
                        ]),
                        ['escape' => false]
                    ) ?>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><?= $this->Html->politicianLink($politician) ?></h4>
                    <p><?= $politician->incumbent === true
                            ? $politician->position ?? __('Unknown Position')
                            : __('Candidate for {position}', [
                                'position' => $politician->position ?? __('Unknown Position')
                            ]) ?></p>
                    <dl class="row">
                        <dt class="col-sm-6">Questions answered</dt>
                        <dd class="col-sm-6"><?= $politician->answer_count ?></dd>
                        <dt class="col-sm-6">Articles posted</dt>
                        <dd class="col-sm-6"><?= count($politician->articles) ?></dd>
                        <dt class="col-sm-6">Videos uploaded</dt>
                        <dd class="col-sm-6"><?= count($politician->awards) ?></dd>
                        <dt class="col-sm-6">Previous positions</dt>
                        <dd class="col-sm-6"><?= count($politician->positions) ?></dd>
                        <dt class="col-sm-6">Qualifications</dt>
                        <dd class="col-sm-6"><?= count($politician->qualifications) ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</section>

<div class="text-muted small text-center">
    <?= $this->element('index/pagination') ?>
</div>
