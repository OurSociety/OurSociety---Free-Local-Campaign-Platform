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
<?php $this->end() ?>

<?php $this->start('actions_heading') ?>
<div class="btn-group">
    <?= $this->Html->button(__('Getting Started'), '/docs/onboarding') ?>
    <?= $this->Html->button(__('Example Profile'), ['_name' => 'politician', 'politician' => \OurSociety\Test\Fixture\UsersFixture::POLITICIAN_SLUG], ['class' => 'btn btn-info']) ?>
    <?= $this->Html->button(__('Your Profile'), ['_name' => 'politician:profile:edit'], ['class' => 'btn btn-warning']) ?>
</div>
<?php $this->end() ?>

<?php $this->start('actions_articles') ?>
<?= $this->Html->button('Edit Articles', ['_name' => 'politician:profile:articles'], ['secondary' => true, 'size' => 'sm']) ?>
<?php $this->end() ?>

<?php $this->start('actions_videos') ?>
<?= $this->Html->button('Edit Videos', ['_name' => 'politician:profile:videos'], ['secondary' => true, 'size' => 'sm']) ?>
<?php $this->end() ?>

<?php $this->start('actions_positions') ?>
<?= $this->Html->button('Edit Positions', ['_name' => 'politician:profile:positions'], ['secondary' => true, 'size' => 'sm']) ?>
<?php $this->end() ?>

<?php $this->start('actions_education') ?>
<?= $this->Html->button('Edit Qualifications', ['_name' => 'politician:profile:qualifications'], ['secondary' => true, 'size' => 'sm']) ?>
<?php $this->end() ?>

<?php $this->start('actions_awards') ?>
<?= $this->Html->button('Edit Awards', ['_name' => 'politician:profile:awards'], ['secondary' => true, 'size' => 'sm']) ?>
<?php $this->end() ?>

<?php $this->start('actions_born') ?>
<?= $this->Html->button('Edit Profile', ['_name' => 'politician:profile:edit'], ['secondary' => true, 'size' => 'sm']) ?>
<?php $this->end() ?>
