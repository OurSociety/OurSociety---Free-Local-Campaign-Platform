<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The profile being edited.
 */
?>
<ol class="breadcrumb">
    <li><?= $this->Html->link(__('Account profile'), ['_name' => 'users:profile']) ?></li>
    <li>Edit details</li>
</ol>

<section class="users form">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit your profile') ?></legend>
        <?= $this->Form->control('name', ['label' => __('Full name')]) ?>
        <?= $this->Form->control('email', ['email' => __('Email address')]) ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')); ?>
    <?= $this->Form->end() ?>
</section>
