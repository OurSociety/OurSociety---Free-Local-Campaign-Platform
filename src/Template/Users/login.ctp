<?php

use OurSociety\Controller\AppController;

/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user entity.
 */

$this->set('title', 'Sign In');
?>

<div class="row">
    <div class="col-md-6 p-5 bg-light os-bg-split-light">
        <div class="row pb-3">
            <div class="col d-flex align-items-center">
                <h1 class="text-nowrap mb-0">
                    <?= __('Sign In') ?>
                </h1>
            </div>
            <div class="col col-auto text-muted mb-2 d-flex align-items-center">
                <?= __('No account yet?') ?>
                <?= $this->Html->link(
                    __('Join OurSociety'),
                    ['_name' => 'users:register'],
                    ['class' => ['btn', 'btn-outline-primary', 'btn-sm', 'ml-2']]
                ) ?>
            </div>
        </div>

        <section class="users form">
            <?= $this->Form->create('User') ?>
            <fieldset>
                <legend class="text-nowrap">
                    <?= __('Enter email and password') ?>
                </legend>
                <?= $this->Form->control('email', [
                    'label' => false,
                    'placeholder' => __('Email Address'),
                    'required' => true,
                    'default' => $this->request->getQuery('email'),
                ]) ?>
                <?= $this->Form->control('password', [
                    'label' => false,
                    'placeholder' => __('Password'),
                    'required' => true,
                    'help' => $this->Html->div(
                        'text-right',
                        $this->Html->link(
                            __('Forgot password?'),
                            ['_name' => 'users:forgot']
                        )
                    ),
                ]) ?>
            </fieldset>
            <div class="row">
                <div class="col">
                    <?= $this->Form->control(AppController::COOKIE_NAME_REMEMBER_ME, [
                        'type' => 'checkbox',
                        'label' => __('Keep me signed in'),
                        'checked' => true,
                    ]) ?>
                </div>
                <div class="col col-md-5 col-lg-3">
                    <?= $this->Form->button(__('Sign In'), ['class' => ['btn-secondary btn-block btn-lg']]); ?>
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
