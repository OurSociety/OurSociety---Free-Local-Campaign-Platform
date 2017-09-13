<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var User $pathwayPolitician The pathway politician.
 * @var User $currentUser The current user.
 */
use OurSociety\Model\Entity\User;

?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><?= $this->Html->dashboardLink() ?></li>
    <li class="breadcrumb-item"><?= $this->Html->link(__('Profile'), ['_name' => 'politician:profile']) ?></li>
    <li class="breadcrumb-item active"><?= __('Edit Profile') ?></li>
</ol>

<h2>
    <?= __('Edit Profile') ?>
    <?php if ($currentUser->isPolitician()): ?>
        <?= $this->Html->link(__('Back to Profile'), ['_name' => 'politician:profile'], ['class' => 'btn btn-outline-dark pull-right']) ?>
    <?php endif ?>
</h2>

<hr>

<section class="users form">
    <?= $this->Form->create($pathwayPolitician, ['align' => ['sm' => ['left' => 3, 'middle' => 9]], 'type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Account Details') ?></legend>
        <?= $this->Form->control('role', ['value' => User::ROLE_CITIZEN, 'type' => 'hidden']) ?>
        <?= $this->Form->control('name', ['label' => __('Full Display Name'), 'help' => 'e.g. Sen. John Doe']) ?>
        <?= $this->Form->control('email', ['label' => __('Email Address')]) ?>
        <?= $this->Form->control('picture', [
            'label' => __('Profile Picture'),
            'type' => 'file',
            'help' => __('Accepted file formats: GIF/JPEG/PNG - Maximum file size: 5 MB'),
        ]) ?>
    </fieldset>
    <?= $this->Form->button(__('Update Profile'), ['class' => ['btn', 'btn-primary', 'pull-right']]); ?>
    <?= $this->Form->end() ?>
</section>
