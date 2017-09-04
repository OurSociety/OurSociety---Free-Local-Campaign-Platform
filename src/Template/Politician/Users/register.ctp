<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var User $user The user.
 */
use OurSociety\Model\Entity\User;

?>
<ol class="breadcrumb">
    <li><?= $this->Html->dashboardLink() ?></li>
    <li><?= __('Politician Registration') ?></li>
</ol>

<h2><?= __('Politician Registration') ?></h2>

<hr>

<section class="users form">
    <?= $this->Form->create($user, ['align' => [
        'sm' => [
            'left' => 3,
            'middle' => 9
        ]
    ]]) ?>
    <fieldset>
        <legend><?= __('Account Details') ?></legend>
        <?= $this->Form->control('role', ['value' => User::ROLE_POLITICIAN, 'type' => 'hidden']) ?>
        <?= $this->Form->control('name', ['label' => __('Full Display Name'), 'help' => 'e.g. Sen. John Doe']) ?>
        <?= $this->Form->control('email', ['label' => __('Email Address')]) ?>
        <?= $this->Form->control('password') ?>
        <?= $this->Form->control('incumbent', ['label' => __('Electoral Status'), 'options' => [
            false => __('Candidate'),
            true => __('Elected Official'),
        ]]) ?>
        <?= $this->Form->control('office_type_id', ['label' => __('Electoral Office')]) ?>
    </fieldset>
    <fieldset>
        <legend><?= __('Home Address') ?></legend>
        <?= $this->Form->control('address_1', ['label' => __('Address Line 1')]) ?>
        <?= $this->Form->control('address_2', ['label' => __('Address Line 2')]) ?>
        <?= $this->Form->control('city', ['label' => __('City')]) ?>
        <?= $this->Form->control('state', ['label' => __('State'), 'options' => User::STATES]) ?>
        <?= $this->Form->control('zip', ['label' => __('ZIP Code')]) ?>
        <?= $this->Form->control('phone', ['label' => __('Phone Number')]) ?>
    </fieldset>
    <fieldset>
        <legend><?= __('Birth Information') ?></legend>
        <?= $this->Form->control('birth_name', ['label' => 'Full Name at Birth', 'help' => 'e.g. John Doe II']) ?>
        <?= $this->Form->control('birth_city', ['label' => 'City of Birth']) ?>
        <?= $this->Form->control('birth_state', ['label' => 'State of Birth', 'options' => User::STATES]) ?>
        <?= $this->Form->control('birth_country', ['label' => 'Country of Birth', 'options' => User::COUNTRIES]) ?>
        <?= $this->Form->control('born', [
            'label' => 'Date of Birth',
            'type' => 'date',
            'maxYear' => date('Y'),
            'minYear' => 1900,
        ]) ?>
    </fieldset>
    <?= $this->Form->button(__('Register'), ['class' => ['btn', 'btn-primary', 'pull-right']]); ?>
    <?= $this->Form->end() ?>
</section>

<br><br>
