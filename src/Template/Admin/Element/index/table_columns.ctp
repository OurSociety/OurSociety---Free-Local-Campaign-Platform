<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $entity
 */
?>

<?php foreach ($entity->getScaffoldFieldList() as $field): ?>
    <?= $field->renderTableCell($entity, $this) ?>
<?php endforeach ?>
