<?php

use OurSociety\Model\Entity\User;

/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var User $user The user entity.
 */

$this->set('title', 'Join OurSociety');
?>

<div class="row" id="app">
    <div class="col-md-6 p-5 os-bg-split-light">
        <div class="row pb-3">
            <div class="col d-flex align-items-center">
                <h1 class="text-nowrap mb-0">
                    <?= __('Join OurSociety') ?>
                </h1>
            </div>
            <div class="col col-auto text-muted mb-2 d-flex align-items-center">
                <?= __('Have an account?') ?>
                <?= $this->Html->link(
                    __('Sign in'),
                    ['_name' => 'users:login'],
                    ['class' => ['btn', 'btn-outline-primary', 'btn-sm', 'ml-2']]
                ) ?>
            </div>
        </div>

        <section class="users form">
            <?= $this->Form->create($user ?? new User, ['url' => ['_name' => 'users:register']]) ?>
            <fieldset>
                <legend class="text-nowrap">
                    <?= __('Register an account') ?>
                </legend>
                <?= $this->Form->control('name', [
                    'placeholder' => __('Full name'),
                    'label' => false,
                    'required' => true,
                ]) ?>
                <?= $this->Form->control('email', [
                    'placeholder' => __('Email address'),
                    'label' => false,
                    'required' => true,
                ]) ?>
                <password-field>
                    <?= $this->Form->control('password', [
                        'placeholder' => __('Password'),
                        'label' => false,
                        'required' => true,
                    ]) ?>
                </password-field>
            </fieldset>
            <div class="row">
                <div class="col">
                    <small>
                        <?= __('Already have an account?') ?>
                        <?= $this->Html->link(__('Sign in!'), ['_name' => 'users:login']) ?>
                    </small>
                </div>
                <div class="col col-md-7 col-lg-5">
                    <?= $this->Form->button(__('Join OurSociety'), ['class' => ['btn-secondary', 'btn-block', 'btn-lg']]) ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </section>
    </div>

    <div class="col-md-6 p-5 text-white os-bg-split-dark">
        <h1 class="display-4 mb-5" style="font-weight: bold">
            <?= __('Our Purpose') ?>
        </h1>
        <h4 class="mb-5">
            <?= __('Create a more transparent, collaborative, and highly engaged democratic process that empowers grassroots leadership.') ?>
        </h4>
        <h2>
            <?= $this->element('Layout/brand') ?>
        </h2>
    </div>
</div>
