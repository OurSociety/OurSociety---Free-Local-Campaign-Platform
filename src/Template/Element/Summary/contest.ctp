<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Contest $contest
 */
?>
<?php if ($contest->election): ?>
    <small><?= $contest->election->date ?></small>
    <?= $contest->election->renderLink($this) ?>:
<?php endif ?>
<?= $contest->name ?>
