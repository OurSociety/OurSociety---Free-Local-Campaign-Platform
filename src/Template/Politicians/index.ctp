<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var string $title
 * @var \OurSociety\Model\Entity\User[]|\Cake\ORM\ResultSet $politicians The list of politicians.
 */

$this->Breadcrumbs->add($title);
?>

<h1>
    <?= __($title) ?>
</h1>

<section class="row equal-height">
    <?php foreach ($politicians as $politician): ?>
        <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 pb-3">
            <div class="card w-100">
                <?= $this->Html->politicianLink(
                    $politician,
                    $this->Html->jdenticon($politician->slug, [
                        'class' => ['card-img-top bg-light'],
                        'alt' => __('Profile picture of {politician_name}', ['politician_name' => $politician->name]),
                        'height' => '150',
                    ]),
                    ['escape' => false]
                ) ?>
                <div class="card-body">
                    <h4 class="card-title"><?= $this->Html->politicianLink($politician) ?></h4>
                    <p class="card-text">
                        <?= $politician->printPosition() ?>
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</section>

<div class="text-muted small text-center">
    <?= $this->element('index/pagination') ?>
</div>
