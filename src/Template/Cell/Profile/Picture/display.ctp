<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user to display picture for.
 */

$alternateText = __('Profile picture of {user_name}', [
    'user_name' => $user->name,
]);
?>

<?php if ($user->picture !== null): ?>
    <?= $this->Html->image($user->picture, [
        'alt' => $alternateText,
        'class' => ['img-responsive'],
    ]) ?>
<?php else: ?>
    <?= $this->Html->jdenticon($user->slug, [
        'alt' => $alternateText,
        'width' => '100%',
    ]) ?>
<?php endif ?>
