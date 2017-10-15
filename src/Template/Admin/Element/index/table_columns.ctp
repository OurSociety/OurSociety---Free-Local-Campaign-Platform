<?php

use OurSociety\ORM\TableRegistry;
use OurSociety\View\Component\Field\FieldList;

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $entity
 * @var array $fields The CrudView fields.
 */

if (method_exists($entity, 'getScaffoldFieldList')) {
    $fieldList = $entity->getScaffoldFieldList();
} else {
    $fieldList = FieldList::fromArray(TableRegistry::get($entity->getSource()), $fields);
}
?>

<?php foreach ($fieldList as $field): ?>
    <?= $field->renderTableCell($entity, $this) ?>
<?php endforeach ?>
