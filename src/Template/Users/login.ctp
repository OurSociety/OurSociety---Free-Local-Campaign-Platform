<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 */
?>

<section class="users form">
    <?= $this->Form->create('User') ?>
    <fieldset>
        <div class="row">
            <div class="col">
                <legend><?= __('Sign In') ?></legend>
            </div>
            <div class="col col-auto text-muted">
                No account yet?
                <?= $this->Html->link(__('Join OurSociety'), ['_name' => 'users:register'], ['class' => 'btn btn-outline-primary btn-sm ml-2']) ?>
            </div>
        </div>
        <?= $this->Form->control('email', [
            'label' => false,
            'placeholder' => 'Email Address',
            'required' => true,
            'default' => $this->request->getQuery('email'),
        ]) ?>
        <?= $this->Form->control('password', [
            'label' => false,
            'placeholder' => 'Password',
            'required' => true,
            'help' => $this->Html->link(__('Forgot password?'), ['_name' => 'users:forgot'])
        ]) ?>
    </fieldset>
    <div class="row">
        <div class="col">
            <?= $this->Form->control(
                \OurSociety\Controller\AppController::COOKIE_NAME_REMEMBER_ME,
                ['type' => 'checkbox', 'label' => __('Remember me'), 'checked' => true]
            ) ?>
        </div>
        <div class="col col-md-4 col-lg-2">
            <?= $this->Form->button(__('Sign In'), ['class' => ['btn-secondary btn-block btn-lg']]); ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</section>
