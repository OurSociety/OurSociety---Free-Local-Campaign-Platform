<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Layout\DropdownItem $dropdownItem
 */
?>

<?= $this->Html->link(
    $dropdownItem->getTitle($this->request),
    $dropdownItem->getUrl(),
    $dropdownItem->getOptions($this->request)
) ?>
