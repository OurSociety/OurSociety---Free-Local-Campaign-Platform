<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\User $politician The politician.
 */

$email = $politician->verified === null ? $politician->email : $politician->email_temp;
?>

<?= $this->fetch('profile_picture') ?>

<p>
    <?= $politician->phone ?>
</p>

<p>
    <?= $this->Html->link($email, sprintf('mailto:%s', $email)) ?>
</p>
