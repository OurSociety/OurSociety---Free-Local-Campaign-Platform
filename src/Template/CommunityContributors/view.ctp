<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User|null $currentUser The currently logged in user, if any.
 * @var \OurSociety\Model\Entity\User $politician The currently viewed politician.
 */

$this->Breadcrumbs->add(__('My Municipality'), ['_name' => 'municipality:default']);
$this->Breadcrumbs->add(__('Community Contributor'));
$this->Breadcrumbs->add($politician->name);
?>

<?php $this->extend('/Common/CommunityContributors/view') ?>

<?php $this->start('actions_heading') ?>
    <?= $this->Html->link(__('Your Profile'), ['_name' => 'citizen:profile:edit'], ['class' => 'btn btn-warning']) ?>
<?php $this->end() ?>

<?php $this->start('profile_picture') ?>
    <?= $this->cell('Profile/Picture', [], ['user' => $politician]) ?>
<?php $this->end() ?>
