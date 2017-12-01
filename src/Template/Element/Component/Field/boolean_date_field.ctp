<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Field\BooleanDateField $booleanDateField
 */
?>

<?= $this->Html->badge(
    sprintf('%s %s', $this->Html->icon($booleanDateField->getIconName()), $booleanDateField->getBadgeTitle()),
    ['type' => $booleanDateField->getBadgeStyle()]
) ?>
