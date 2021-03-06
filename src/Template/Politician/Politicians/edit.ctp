<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var User $politician The politician.
 * @var User $identity The current user.
 */

use OurSociety\Model\Entity\User;

$this->Breadcrumbs->add(__('My Dashboard'), $identity->getDashboardRoute());
$this->Breadcrumbs->add(__('My Profile'), $identity->getProfileRoute());
$this->Breadcrumbs->add(__('Edit Profile'));
?>

<h2>
    <?= __('Edit Profile') ?>
    <?php if ($identity->isPolitician()): ?>
        <?= $this->Html->link(__('Back to Profile'), ['_name' => 'politician:profile'], ['class' => 'btn btn-default pull-right']) ?>
    <?php endif ?>
</h2>

<hr>

<section class="users form">
    <?= $this->Form->create($politician, [
        'layout' => [
            'type' => 'grid',
            'classes' => [
                'submitContainer' => ['col-sm-10', 'offset-sm-2', 'p-1'],
            ],
        ],
        'type' => 'file',
    ]) ?>
    <fieldset>
        <legend><?= __('Account Details') ?></legend>
        <?= $this->Form->control('role', ['value' => User::ROLE_POLITICIAN, 'type' => 'hidden']) ?>
        <?= $this->Form->control('name', ['label' => __('Full Display Name'), 'help' => 'e.g. Sen. John Doe']) ?>
        <?= $this->Form->control('email', ['label' => __('Email Address')]) ?>
        <?= $this->Form->control('picture', [
            'label' => __('Profile Picture'),
            'type' => 'file',
            'help' => __('Accepted file formats: GIF/JPEG/PNG - Maximum file size: 5 MB'),
        ]) ?>
    </fieldset>
    <fieldset>
        <legend><?= __('Home Address') ?></legend>
        <?= $this->Form->control('address_1', ['label' => __('Address Line 1')]) ?>
        <?= $this->Form->control('address_2', ['label' => __('Address Line 2')]) ?>
        <?= $this->Form->control('city', ['label' => __('City')]) ?>
        <?= $this->Form->control('state', ['label' => __('State'), 'options' => User::STATES, 'empty' => true]) ?>
        <?= $this->Form->control('zip', ['label' => __('ZIP Code'), 'type' => 'zip']) ?>
        <?= $this->Form->control('phone', ['label' => __('Phone Number')]) ?>
    </fieldset>
    <fieldset>
        <legend><?= __('Birth Information') ?></legend>
        <?= $this->Form->control('birth_name', ['label' => 'Full Name', 'help' => 'e.g. John Doe II']) ?>
        <?= $this->Form->control('birth_city', ['label' => 'City of Birth']) ?>
        <?= $this->Form->control('birth_state', ['label' => 'State of Birth', 'options' => User::STATES, 'empty' => true]) ?>
        <?= $this->Form->control('birth_country', ['label' => 'Country of Birth', 'options' => User::COUNTRIES]) ?>
        <?= $this->Form->control('born', [
            'label' => 'Date of Birth',
            'type' => 'date',
            'default' => '1900-01-01',
        ]) ?>
    </fieldset>
    <?= $this->Form->button(__('Update Profile'), ['class' => ['btn', 'btn-primary', 'pull-right']]); ?>
    <?= $this->Form->end() ?>
</section>
