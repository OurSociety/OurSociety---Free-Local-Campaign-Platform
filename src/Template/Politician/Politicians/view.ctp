<?php
/**
 * @var \OurSociety\View\AppView $this
 */
?>

<?php $this->extend('/Common/Politicians/view') ?>

<?php $this->start('breadcrumbs') ?>
<ol class="breadcrumb">
    <li><?= $this->Html->dashboardLink() ?></li>
    <li><?= __('Profile') ?></li>
</ol>
<?php $this->end() ?>

<?php $this->start('actions_heading') ?>
<?= $this->Html->link('Edit Profile', ['_name' => 'politician:profile:edit'], ['class' => 'btn btn-default pull-right']) ?>
<?php $this->end() ?>

<?php $this->start('actions_articles') ?>
<?= $this->Html->link('Edit Articles', ['_name' => 'politician:profile:articles'], ['class' => 'btn btn-sm btn-default pull-right']) ?>
<?php $this->end() ?>

<?php $this->start('actions_videos') ?>
<?= $this->Html->link('Edit Videos', ['_name' => 'politician:profile:videos'], ['class' => 'btn btn-sm btn-default']) ?>
<?php $this->end() ?>

<?php $this->start('actions_positions') ?>
<?= $this->Html->link('Edit Positions', ['_name' => 'politician:profile:positions'], ['class' => 'btn btn-sm btn-default pull-right']) ?>
<?php $this->end() ?>

<?php $this->start('actions_education') ?>
<?= $this->Html->link('Edit Qualifications', ['_name' => 'politician:profile:qualifications'], ['class' => 'btn btn-sm btn-default pull-right']) ?>
<?php $this->end() ?>

<?php $this->start('actions_awards') ?>
<?= $this->Html->link('Edit Awards', ['_name' => 'politician:profile:awards'], ['class' => 'btn btn-sm btn-default pull-right']) ?>
<?php $this->end() ?>

<?php $this->start('actions_born') ?>
<?= $this->Html->link('Edit Profile', ['_name' => 'politician:profile:edit'], ['class' => 'btn btn-sm btn-default pull-right']) ?>
<?php $this->end() ?>
