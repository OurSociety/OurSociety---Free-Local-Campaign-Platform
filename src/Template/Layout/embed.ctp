<?php
/**
 * Embed layout.
 *
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $currentUser The current user.
 */
$this->extend('base');

$callToActionLink = $this->Url->build([
    '_name' => 'users:register',
    '?' => [
        'redirect' => $this->Url->build(['_name' => 'citizen:questions'])
    ]
]);
?>

<header class="os-embed-navbar navbar navbar-expand navbar-dark flex-row">
    <div class="col-auto mr-auto">
        <a href="<?= $callToActionLink ?>" aria-label="OurSociety" class="navbar-brand">
            <svg class="align-middle" width="36" height="36" xmlns="http://www.w3.org/2000/svg" focusable="false">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/img/brand-sprite.svg#logo-white-transparent"></use>
            </svg>
            OurSociety
        </a>
    </div>
    <div class="col-auto">
        <a href="<?= $callToActionLink ?>" class="btn btn-os-yellow d-inline-block align-middle pull-right">
            <?= __('Get Matched') ?>
        </a>
    </div>
</header>

<div class="container-fluid">
    <?= $this->fetch('content') ?>

    <div class="row">
        <div class="col-auto mx-auto">
            <a href="<?= $callToActionLink ?>" class="btn btn-os-purple d-inline-block align-middle pull-right">
                <?= __('Get Matched') ?>
            </a>
        </div>
    </div>
</div>
