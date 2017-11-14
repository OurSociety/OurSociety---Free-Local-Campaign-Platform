<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Layout\NavLink $navLink
 */
?>

<?= $this->Html->link(
    $navLink->getTitle($this->request),
    $navLink->getUrl(),
    $navLink->getOptions($this->request)
) ?>
