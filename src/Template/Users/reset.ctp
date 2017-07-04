<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user entity.
 */
?>
<section class="users form">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Please enter the new password') ?></legend>
        <?php if (!isset($currentUser)) : ?>
            <?= $this->Form->control('email', [
                'type' => 'email',
                'required' => true,
                'label' => __('Email')]);
            ?>
        <?php endif; ?>
        <?php if (!isset($currentUser) || ($validatePassword ?? true)) : ?>
            <?= $this->Form->control('current_password', [
                'type' => 'password',
                'required' => true,
                'label' => __('Current password')]);
            ?>
        <?php endif; ?>
        <?= $this->Form->control('password', [
            'type' => 'password',
            'required' => true,
            'label' => __('New password')]);
        ?>
        <?= $this->Form->control('password_confirm', [
            'type' => 'password',
            'required' => true,
            'label' => __('Confirm password')]);
        ?>

    </fieldset>
    <?= $this->Form->button(__('Submit')); ?>
    <?= $this->Form->end() ?>
</section>
