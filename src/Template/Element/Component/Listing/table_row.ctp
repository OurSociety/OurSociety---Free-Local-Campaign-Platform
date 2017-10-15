<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Listing\TableRow $tableRow
 */

use OurSociety\View\Component\Listing\TableCell;

?>

<tr>

    <?php if ($tableRow->hasButtonGroup() === true): ?>
        <td class="actions">
            <?= $this->Component->render($tableRow->getButtonGroup()) ?>
        </td>
    <?php endif ?>

    <?php foreach ($tableRow->getFieldList() as $field): ?>
        <?= $this->Component->render(new TableCell(
            $tableRow,
            $field,
            $tableRow->getRecord()
        )) ?>
    <?php endforeach ?>

</tr>
