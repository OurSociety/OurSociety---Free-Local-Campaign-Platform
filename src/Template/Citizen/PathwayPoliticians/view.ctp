<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User|null $currentUser The currently logged in user, if any.
 * @var \OurSociety\Model\Entity\User $politician The currently viewed politician.
 */
?>

<?php $this->extend('/Common/PathwayPoliticians/view') ?>

<?php $this->start('breadcrumbs'); ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= $this->Html->link(__('My Municipality'), ['_name' => 'municipality:default']) ?></li>
        <li class="breadcrumb-item"><?= __('Pathway Politicians') ?></li>
        <li class="breadcrumb-item active"><?= __('My Profile') ?></li>
    </ol>
<?php $this->end() ?>

<?php $this->start('actions_heading') ?>
    <div class="btn-group">
        <?= $this->Html->link(__('Getting Started'), '/docs/onboarding', ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link(__('Example Profile'), ['_name' => 'pathway-politician', 'citizen' => 'ron-rivers'], ['class' => 'btn btn-info']) ?>
        <?= $this->Html->link(__('Your Profile'), ['_name' => 'citizen:profile:edit'], ['class' => 'btn btn-warning']) ?>
    </div>
<?php $this->end() ?>

<?php $this->start('profile_picture') ?>
    <?= $this->cell('Profile/Picture', [], ['user' => $politician]) ?>
    <?=''// $this->cell('Profile/Picture::edit', [], ['user' => $politician]) ?>
<?php $this->end() ?>
