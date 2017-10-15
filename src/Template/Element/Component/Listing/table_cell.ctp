<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Listing\TableCell $tableCell
 */

$field = $tableCell->getField()
    ->withRecord($tableCell->getRecord());
?>

<?= $this->Html->tag(
    $tableCell->getTagName(),
    $this->Component->render($field)
) ?>
