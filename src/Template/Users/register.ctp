<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user entity.
 */
?>
<section class="users form">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Register an account') ?></legend>
        <?= $this->Form->control('name', ['label' => __('Full name')]) ?>
        <?= $this->Form->control('email', ['label' => __('Email address')]) ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
    <?= $this->Form->button(__('Register')); ?>
    <?= $this->Form->end() ?>
</section>
