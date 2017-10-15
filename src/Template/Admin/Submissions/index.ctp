<?php

use OurSociety\View\Component\Button\CreateButton;
use OurSociety\View\Component\Button\ViewButton;
use OurSociety\View\Component\Field\{
    BooleanField, DateField, ReferenceField
};
use OurSociety\View\Component\Listing\Listing;

/**
 * @var \OurSociety\View\AppView $this
 * @var \Cake\ORM\ResultSet $records
 */

$this->Breadcrumbs->add('Tables');
$this->Breadcrumbs->add('Submissions');
?>

<?= $this->Component->render(new Listing([
    new DateField('created', ['title' => 'Date Reported']),
    new ReferenceField('user', ['title' => 'Submitting User']),
    new BooleanField('done', ['title' => 'Done?']),
    new CreateButton,
    new ViewButton,
], $records)) ?>
