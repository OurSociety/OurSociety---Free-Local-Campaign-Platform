<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 */
?>
<section class="users form">
    <?= $this->Form->create('User') ?>
    <fieldset>
        <legend><?= __('Please enter your email and password') ?></legend>
        <?= $this->Form->control('email', ['required' => true]) ?>
        <?= $this->Form->control('password', ['required' => true]) ?>
        <?= $this->Form->control('remember_me', ['type' => 'checkbox', 'label' => __('Remember me'), 'checked' => true]) ?>
        <?= $this->Html->link(__('Register'), ['_name' => 'users:register']) ?>
        |
        <?= $this->Html->link(__('Reset Password'), ['_name' => 'users:reset']) ?>
    </fieldset>
    <?= $this->Form->button(__('Login')); ?>
    <?= $this->Form->end() ?>
</section>
