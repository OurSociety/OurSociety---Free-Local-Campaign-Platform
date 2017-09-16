<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\User $politician The politician.
 * @var \OurSociety\Model\Entity\User $currentUser The currently logged in user.
 */
?>

<?= $this->fetch('prepend_value_match') ?>

<?= $this->cell('Profile/ValueMatch', [
    $politician,
    $currentUser,
]) ?>
