<?php

use OurSociety\View\Component\Listing\TableRow;

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Listing\TableBody $tableBody
 */
?>

<tbody>
<?php foreach ($tableBody->getRecords() as $record): ?>
    <?= $this->Component->render(new TableRow($tableBody, $record)) ?>
<?php endforeach; ?>
</tbody>
