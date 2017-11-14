<?php
/**
 * Embed layout.
 *
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $identity The current user.
 */
$this->extend('base');

$redirectUrl = $this->Url->build(['_name' => 'citizen:questions']);
$callToActionUrl = $this->Url->build(['_name' => 'users:register', '?' => ['redirect' => $redirectUrl]]);
?>

<?= $this->element('Layout/navbar_embed', ['callToActionUrl' => $callToActionUrl]) ?>

<div class="container-fluid">
    <?= $this->fetch('content') ?>

    <div class="row">
        <div class="col-auto mx-auto">
            <a href="<?= $callToActionUrl ?>" class="btn btn-os-purple d-inline-block align-middle pull-right">
                <?= __('Get Matched') ?>
            </a>
        </div>
    </div>
</div>
