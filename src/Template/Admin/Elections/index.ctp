<?php

use OurSociety\View\Component\Button\ViewButton;
use OurSociety\View\Component\Field\{
    BooleanField, DateField, TextField
};
use OurSociety\View\Component\Listing\Listing;

/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \Cake\ORM\ResultSet $records The result set.
 */

$this->Breadcrumbs->add('Tables');
$this->Breadcrumbs->add('Elections');

?>

<?= $this->Component->render(new Listing([
    new TextField('name'),
    new DateField('date'),
    //new ReferenceField('state'),
    (new BooleanField('is_state_wide'))->setTitle('State-wide?'),
    new ViewButton,
], $records)) ?>
