<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $politician
 */

$this->Breadcrumbs->add('My Dashboard', ['_name' => 'politician:dashboard']);
$this->Breadcrumbs->add('My Profile')
?>

<?php $this->extend('/Common/Politicians/view') ?>

<?php $this->start('profile_picture') ?>
    <?= $this->cell('Profile/Picture', [], ['user' => $politician]) ?>
    <?=''// $this->cell('Profile/Picture::edit', [], ['user' => $politician]) ?>
<?php $this->end() ?>

<?php $this->start('actions_heading') ?>
    <?= $this->Html->link(__('Getting Started'), '/docs/onboarding', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link(__('Example Profile'), ['_name' => 'politician', 'politician' => \OurSociety\Test\Fixture\UsersFixture::POLITICIAN_SLUG], ['class' => 'btn btn-info']) ?>
    <?= $this->Html->link(__('Your Profile'), ['_name' => 'politician:profile:edit'], ['class' => 'btn btn-warning']) ?>
<?php $this->end() ?>

<?php $this->start('actions_articles') ?>
<?= $this->Html->link('Edit Articles', ['_name' => 'politician:profile:articles'], ['class' => 'btn btn-sm btn-default pull-right']) ?>
<?php $this->end() ?>

<?php $this->start('actions_videos') ?>
<?= $this->Html->link('Edit Videos', ['_name' => 'politician:profile:videos'], ['class' => 'btn btn-sm btn-default', 'id' => 'button-edit-videos']) ?>
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
