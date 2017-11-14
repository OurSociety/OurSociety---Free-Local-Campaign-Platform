<?php

use OurSociety\View\Component\Button\ToggleButton;
use OurSociety\View\Component\Detail\Show;
use OurSociety\View\Component\Field\{
    BooleanField, DateField, ReferenceField, TextField
};

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\RecordInterface $record
 */

$this->Breadcrumbs->add('Tables');
$this->Breadcrumbs->add('Reports', ['action' => 'index']);
$this->Breadcrumbs->add($record->getDisplayValue());
?>

<?= $this->Component->render(new Show($record, [
    new DateField('created', ['title' => 'Date Reported']),
    new ReferenceField('question', ['title' => 'Reported Question']),
    new ReferenceField('user', ['title' => 'Reporting User']),
    new TextField('body', ['title' => 'Report Body']),
    new BooleanField('done', ['title' => 'Done?']),
    new ToggleButton($record, ['title' => ['Mark as done', 'Mark as not done'], 'action' => 'toggle_done', 'field' => 'done']),
])) ?>
