<?php

use OurSociety\View\Component\Listing\Table;
use OurSociety\View\Component\Field\FieldList;

/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \Cake\ORM\ResultSet $results The result set.
 */
?>

<?= $this->Component->render(new Table($results, new FieldList([])), ['results' => $results]) ?>
