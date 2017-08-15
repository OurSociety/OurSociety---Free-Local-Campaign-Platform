<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Election $election
 * @var array|string|null $url
 */
?>
<small><?= $election->date ?></small>
<?= $election->renderLink($this, $url ?? null) ?>
