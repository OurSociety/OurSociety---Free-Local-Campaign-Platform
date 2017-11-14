<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Field\BooleanField $booleanField
 */
?>

<?= $this->Html->badge(
    sprintf('%s %s', $this->Html->icon($booleanField->getIconName()), $booleanField->getBadgeTitle()),
    ['type' => $booleanField->getBadgeStyle()]
) ?>
