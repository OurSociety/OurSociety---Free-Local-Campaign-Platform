<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 */
?>
<section class="users form">
    <?= $this->Form->create('User') ?>
    <fieldset>
        <legend><?= __('Please enter your email and password') ?></legend>
        <?= $this->Form->control('email', ['required' => true, 'default' => $this->request->getQuery('email')]) ?>
        <?= $this->Form->control('password', ['required' => true]) ?>
        <?= $this->Form->control('remember_me', ['type' => 'checkbox', 'label' => __('Remember me'), 'checked' => true]) ?>
        <?= $this->Html->link(__('Register'), ['_name' => 'users:register']) ?>
        <small>(<?= $this->Html->link(__('Forgot Password?'), ['_name' => 'users:forgot']) ?>)</small>
    </fieldset>
    <?= $this->Form->button(__('Login')); ?>
    <?= $this->Form->end() ?>
</section>
