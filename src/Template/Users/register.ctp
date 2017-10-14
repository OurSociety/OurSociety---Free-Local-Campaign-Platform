<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user entity.
 */

$this->set('title', 'Join OurSociety');
?>

<div class="row">
    <div class="col-md-6 p-5 os-bg-split-light">
        <h1 class="pb-3">
            <?= __('Register an account.') ?>
        </h1>

        <section class="users form">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <div class="row">
                    <div class="col">
                        <legend class="text-nowrap">
                            <?= __('Join OurSociety') ?>
                        </legend>
                    </div>
                    <div class="col col-auto text-muted mb-2">
                        <?= __('Already have an account?') ?>
                        <?= $this->Html->link(
                            __('Sign in'),
                            ['_name' => 'users:login'],
                            ['class' => ['btn', 'btn-outline-primary', 'btn-sm', 'ml-2']]
                        ) ?>
                    </div>
                </div>
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
                <?= $this->Form->control('password', [
                    'placeholder' => __('Password'),
                    'label' => false,
                    'required' => true,
                ]) ?>
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
            <?= $this->element('logo') ?>
        </h2>
    </div>
</div>
