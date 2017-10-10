<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user to display picture for.
 */
?>

<?= $user->renderProfilePicture($this) ?>
