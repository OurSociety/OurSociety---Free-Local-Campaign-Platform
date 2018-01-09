<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Field\ReferenceField $referenceField
 */
?>

<?php if ($referenceField->hasReference()): ?>
    <?= $this->Html->link(
        $referenceField->getReferenceTitle(),
        $referenceField->getReferenceUrl(),
        [
            'icon' => $referenceField->getReferenceIcon(),
        ]
    ) ?>
<?php else: ?>
    <?= $this->Html->badge('N/A', ['type' => 'secondary']) ?>
<?php endif ?>
