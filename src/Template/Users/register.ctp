<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user entity.
 */
?>

<section class="users form">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <div class="row">
            <div class="col">
                <legend><?= __('Join OurSociety') ?></legend>
            </div>
            <div class="col col-auto text-muted">
                Already have an account?
                <?= $this->Html->link(__('Sign in'), ['_name' => 'users:login'], ['class' => 'btn btn-outline-primary btn-sm ml-2']) ?>
            </div>
        </div>
        <?= $this->Form->control('name', [
            'placeholder' => __('Full name'),
            'label' => false,
        ]) ?>
        <?= $this->Form->control('email', [
            'placeholder' => __('Email address'),
            'label' => false,
        ]) ?>
        <?= $this->Form->control('password', [
            'placeholder' => __('Password'),
            'label' => false,
        ]) ?>
    </fieldset>
    <div class="row">
        <div class="col">
            <small>
                <?= __('Already have an account?') ?>
                <?= $this->Html->link(__('Sign in!'), ['_name' => 'users:login']) ?>
            </small>
        </div>
        <div class="col col-md-4 col-lg-2">
            <?= $this->Form->button(__('Join OurSociety'), ['class' => ['btn-secondary btn-block btn-lg']]) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</section>
