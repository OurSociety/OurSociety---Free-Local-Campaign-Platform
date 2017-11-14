<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Field\ReferenceField $referenceField
 */
?>

<?= $this->Html->link(
    $referenceField->getReferenceTitle(),
    $referenceField->getReferenceUrl(),
    [
        'icon' => $referenceField->getReferenceIcon(),
    ]
) ?>
