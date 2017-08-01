<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User|null $currentUser The currently logged in user, if any.
 * @var \OurSociety\Model\Entity\User $politician The currently viewed politician.
 */
?>

<?php $this->extend('/Common/Politicians/view') ?>

<?php $this->start('breadcrumbs'); ?>
<ol class="breadcrumb">
    <li><?= $this->Html->dashboardLink() ?></li>
    <li><?= $this->Html->link('Politicians', ['_name' => 'politicians']) ?></li>
    <li><?= $politician->name ?></li>
</ol>
<?php $this->end() ?>

<?php $this->start('profile_picture') ?>
    <?= $this->cell('Profile/Picture', [], ['user' => $politician]) ?>
<?php $this->end() ?>

<?php $this->start('actions_heading') ?>
<?php if ($currentUser === null): ?>
    <?= $this->Html->link(
        __('Claim Your Profile'),
        ['_name' => 'politician:claim', $politician->slug],
        ['class' => ['btn', 'btn-danger']]
    ) ?>
<?php endif ?>
<?php $this->end() ?>
