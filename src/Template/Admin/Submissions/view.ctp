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
$this->Breadcrumbs->add('Submissions', ['action' => 'index']);
$this->Breadcrumbs->add($record->getDisplayValue());
?>

<?= $this->Component->render(new Show($record, [
    new DateField('created', ['title' => 'Date Reported']),
    new ReferenceField('user', ['title' => 'Submitting User']),
    new TextField('body', ['title' => 'Submission Body']),
    new BooleanField('done', ['title' => 'Done?']),
    new ToggleButton($record, ['title' => ['Mark as done', 'Mark as not done'], 'action' => 'toggle_done', 'field' => 'done']),
])) ?>
