<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user entity.
 * @var \OurSociety\Model\Entity\User|null $currentUser The current user.
 */
?>
<section class="users form">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Location information') ?></legend>
        <?= $this->Form->control('electoral_district_id', [
            'empty' => true,
            'required' => true,
            'label' => __('Select your municipality')
        ]) ?>
        <!--
        <?= $this->Form->control('zip', [
            'type' => 'text',
            'required' => true,
            'label' => __('ZIP code')
        ]) ?>
        -->
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</section>
