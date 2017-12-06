<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var User $communityContributor The community contributor.
 * @var User $identity The current user.
 */

use OurSociety\Model\Entity\User;

$this->Breadcrumbs->add(__('My Municipality'), ['_name' => 'municipality:default']);
$this->Breadcrumbs->add(__('Community Contributor'));
$this->Breadcrumbs->add(__('My Profile'), $identity->getPublicProfileRoute());
$this->Breadcrumbs->add(__('Edit Profile'));
?>

<?= $this->Form->create($communityContributor, ['type' => 'file']) ?>

<h2>
    <?= __('Edit Profile') ?>
    <?php if ($identity->isPolitician()): ?>
        <?= $this->Html->link(__('Back to Profile'), ['_name' => 'politician:profile'], ['class' => 'btn btn-outline-dark pull-right']) ?>
    <?php endif ?>
    <?= $this->Form->button(__('Save Changes'), ['class' => ['btn', 'btn-secondary', 'pull-right']]); ?>
</h2>

<hr>

<?= $this->element('../Citizen/CommunityContributors/banner') ?>

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
                <legend><?= __('More Information') ?></legend>
                <?= $this->Form->control('birth_name', ['label' => 'Full Name', 'help' => 'e.g. John Doe II']) ?>
                <?= $this->Form->control('birth_city', ['label' => 'City']) ?>
                <?= $this->Form->control('birth_state', ['label' => 'State', 'options' => User::STATES, 'empty' => true]) ?>
                <?= $this->Form->control('born', ['label' => 'Date of Birth', 'type' => 'date', 'empty' => true]) ?>
            </fieldset>
        </div>
    </div>
</section>

<?= $this->Form->end() ?>
