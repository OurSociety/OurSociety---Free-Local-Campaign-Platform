<?php
declare(strict_types=1);
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User[] $politicians The list of politicians.
 */
?>
<ol class="breadcrumb">
    <li><?= $this->Html->dashboardLink() ?></li>
    <li><?= __('Politicians') ?></li>
</ol>

<h2><?= __('Politicians') ?></h2>

<hr>

<section class="row">
    <?php foreach ($politicians as $politician): ?>
        <div class="col-md-6">
            <div class="media">
                <div class="media-left">
                    <?= $this->Html->politicianLink(
                        $politician,
                        $this->Html->image($politician->picture, [
                            'class' => ['media-object'],
                            'alt' => __('Profile picture of {politician_name}', ['politician_name' => $politician->name]),
                            'style' => 'max-height: 200px',
                        ]),
                        ['escape' => false]
                    ) ?>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><?= $this->Html->politicianLink($politician) ?></h4>
                    <p><?= $politician->position ?></p>
                    <dl class="dl-horizontal">
                        <dt>Questions answered</dt>
                        <dd><?= $politician->answer_count ?></dd>
                        <dt>Articles posted</dt>
                        <dd><?= count($politician->articles) ?></dd>
                        <dt>Videos uploaded</dt>
                        <dd><?= count($politician->awards) ?></dd>
                        <dt>Previous positions</dt>
                        <dd><?= count($politician->positions) ?></dd>
                        <dt>Qualifications</dt>
                        <dd><?= count($politician->qualifications) ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    <?= $this->Paginator->numbers() ?>
</section>
<div class="text-muted small text-center">
<?= $this->element('index/pagination') ?>
</div>
