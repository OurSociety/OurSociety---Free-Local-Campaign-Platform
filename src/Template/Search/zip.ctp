<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user entity.
 * @var \OurSociety\Model\Entity\User|null $identity The current user.
 */
?>
<section class="users form">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Location information') ?></legend>
        <?= $this->Form->control('zip', [
            'type' => 'text',
            'required' => true,
            'label' => __('ZIP code'),
        ]) ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</section>
