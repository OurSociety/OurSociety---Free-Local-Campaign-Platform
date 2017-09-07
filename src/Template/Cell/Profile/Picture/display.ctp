<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user to display picture for.
 */
?>

<?= $this->Html->image($user, [
    'alt' => __('Profile picture of {user_name}', ['user_name' => $user->name]),
    'class' => ['img-responsive'],
    'style' => 'min-width: 100%',
]) ?>
