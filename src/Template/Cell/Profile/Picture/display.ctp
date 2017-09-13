<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user to display picture for.
 */
?>

<?= $this->Html->image($user, [
    'alt' => __('Profile picture of {user_name}', ['user_name' => $user->name]),
    'class' => [
        'img-fluid',
        'img-responsive' // TODO: Remove when bootstrap 3 dropped.
    ],
    'style' => 'min-width: 100%',
]) ?>
