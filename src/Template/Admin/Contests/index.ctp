<?php

use OurSociety\View\Component\Button\ViewButton;
use OurSociety\View\Component\Field\{
    ReferenceField, TextField
};
use OurSociety\View\Component\Listing\Listing;

/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \Cake\ORM\ResultSet $records The result set.
 */

$this->Breadcrumbs->add('Tables');
$this->Breadcrumbs->add('Contests');
?>

<?= $this->Component->render(new Listing([
    new ReferenceField('election'),
    new ReferenceField('electoral_district'),
    new ReferenceField('office'),
    new TextField('name'),
    new ViewButton,
], $records)) ?>
