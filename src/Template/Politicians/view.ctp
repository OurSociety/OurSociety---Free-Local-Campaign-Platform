<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User|null $identity The currently logged in user, if any.
 * @var \OurSociety\Model\Entity\User $politician The currently viewed politician.
 */

$this->Breadcrumbs->add('Representatives', ['_name' => 'politicians']);
$this->Breadcrumbs->add($politician->name);
?>

<?php $this->extend('/Common/Politicians/view') ?>

<?php $this->start('profile_picture') ?>
<?= $politician->renderProfilePicture($this) ?>
<?php $this->end() ?>

<?php $this->start('actions_heading') ?>
<?php if ($identity === null): ?>
    <?= $this->Html->link(
        __('Claim Your Profile'),
        ['_name' => 'politician:claim', $politician->slug],
        ['class' => ['btn', 'btn-danger']]
    ) ?>
<?php endif ?>
<?php $this->end() ?>
