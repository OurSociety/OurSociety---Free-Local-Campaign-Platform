<?php

use OurSociety\View\Component\Detail\Show;
use OurSociety\View\Component\Field\{
    BooleanField, ReferenceField, TextField
};

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\RecordInterface $record
 */

$this->Breadcrumbs->add('Tables');
$this->Breadcrumbs->add('Contests', ['action' => 'index']);
$this->Breadcrumbs->add($record->getDisplayValue());
?>

<?= $this->Component->render(new Show($record, [
    new ReferenceField('election'),
    new ReferenceField('electoral_district'),
    new ReferenceField('office'),
    new ReferenceField('vote_variation'),
    new TextField('name'),
    new TextField('abbreviation'),
    new TextField('number_elected'),
    new TextField('votes_allowed'),
    new TextField('ballot_title'),
    new TextField('ballot_sub_title'),
    new TextField('electorate_specification'),
    new BooleanField('has_rotation'),
    new TextField('sequence_order'),
])) ?>
