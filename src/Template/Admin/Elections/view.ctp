<?php

use OurSociety\View\Component\Detail\Show;
use OurSociety\View\Component\Field\{
    BooleanField, DateField, ReferenceField, TextField
};

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\RecordInterface $record
 */

$this->Breadcrumbs->add('Tables');
$this->Breadcrumbs->add('Elections', ['action' => 'index']);
$this->Breadcrumbs->add($record->getDisplayValue());
?>

<?= $this->Component->render(new Show($record, [
    new TextField('name'),
    new DateField('date'),
    new TextField('election_type'),
    new ReferenceField('state'),
    new TextField('is_state_wide'),
    new TextField('registration_info'),
    new TextField('absentee_ballot_info'),
    new TextField('results_uri'),
    new BooleanField('has_election_day_registration'),
    new DateField('registration_deadline'),
    new DateField('absentee_request_deadline'),
])) ?>
