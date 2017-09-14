<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user entity.
 * @var \OurSociety\Model\Entity\User|null $currentUser The current user.
 */

$this->Breadcrumbs->add(__('Account profile'), $currentUser ? ['_name' => 'users:profile'] : null);
$this->Breadcrumbs->add(__('Password reset'));
?>

<section class="users form">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Please enter your new password') ?></legend>
        <?php if ($this->request->getQuery('token') === null): ?>
            <?= $this->Form->control('token', [
                'required' => true,
                'label' => __('Verification code'),
                'maxlength' => \OurSociety\Model\Entity\User::TOKEN_LENGTH,
            ]) ?>
        <?php endif ?>
        <?php if ($currentUser === null && $this->request->getQuery('email') === null): ?>
            <?= $this->Form->control('email', [
                'type' => 'email',
                'required' => true,
                'label' => __('Email')
            ]) ?>
        <?php endif ?>
        <?php if ($currentUser !== null): ?>
            <?= $this->Form->control('current_password', [
                'type' => 'password',
                'required' => true,
                'label' => __('Current password')
            ]) ?>
        <?php endif ?>
        <?= $this->Form->control('password', [
            'type' => 'password',
            'required' => true,
            'label' => __('New password')
        ]) ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</section>
