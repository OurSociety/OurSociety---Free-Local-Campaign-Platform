<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var User $communityContributor The community contributor.
 * @var User $currentUser The current user.
 */
use OurSociety\Model\Entity\User;

?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><?= $this->Html->dashboardLink() ?></li>
    <li class="breadcrumb-item"><?= $this->Html->link(__('Profile'), ['_name' => 'citizen:profile']) ?></li>
    <li class="breadcrumb-item active"><?= __('Edit Profile') ?></li>
</ol>

<?= $this->Form->create($communityContributor, ['align' => ['sm' => ['left' => 3, 'middle' => 9]], 'type' => 'file']) ?>

<h2>
    <?= __('Edit Profile') ?>
    <?php if ($currentUser->isPolitician()): ?>
        <?= $this->Html->link(__('Back to Profile'), ['_name' => 'politician:profile'], ['class' => 'btn btn-outline-dark pull-right']) ?>
    <?php endif ?>
    <?= $this->Form->button(__('Save Changes'), ['class' => ['btn', 'btn-secondary', 'pull-right']]); ?>
</h2>

<hr>

<section class="users form">
    <div class="row">
        <div class="col-md-6">
            <fieldset>
                <legend><?= __('Account Details') ?></legend>
                <?= $this->Form->control('role', ['value' => User::ROLE_CITIZEN, 'type' => 'hidden']) ?>
                <?= $this->Form->control('name', ['label' => __('Full Display Name'), 'help' => 'e.g. Sen. John Doe']) ?>
                <?= $this->Form->control('email', ['label' => __('Email Address')]) ?>
                <?= $this->Form->control('picture', [
                    'label' => __('Profile Picture'),
                    'type' => 'file',
                    'help' => __('Accepted file formats: GIF/JPEG/PNG - Maximum file size: 5 MB'),
                ]) ?>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset>
                <legend><?= __('Birth Information') ?></legend>
                <?= $this->Form->control('birth_name', ['label' => 'Full Name at Birth', 'help' => 'e.g. John Doe II']) ?>
                <?= $this->Form->control('birth_city', ['label' => 'City of Birth']) ?>
                <?= $this->Form->control('birth_state', ['label' => 'State of Birth', 'options' => User::STATES, 'empty' => true]) ?>
                <?= $this->Form->control('birth_country', ['label' => 'Country of Birth', 'options' => User::COUNTRIES]) ?>
                <?= $this->Form->control('born', [
                    'label' => 'Date of Birth',
                    'type' => 'date',
                    'empty' => true,
                    //'default' => '1900-01-01',
                ]) ?>
            </fieldset>
        </div>
    </div>
</section>

<?= $this->Form->end() ?>
