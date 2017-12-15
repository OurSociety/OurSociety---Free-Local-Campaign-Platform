<?php

use OurSociety\View\Component\Button\{
    CreateButton, DeleteButton, EditButton
};
use OurSociety\View\Component\Field\{
    DateField, TextField
};
use OurSociety\View\Component\Listing\Listing;

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $identity
 * @var \OurSociety\Model\Entity\Award[]|\Cake\Datasource\ResultSetInterface $records
 */

$this->Breadcrumbs->add(__('My Dashboard'), $identity->getDashboardRoute());
$this->Breadcrumbs->add(__('My Profile'), $identity->getProfileRoute());
$this->Breadcrumbs->add(__('My Awards'));

$listing = (new Listing([
    (new TextField('name'))->setTitle('Award Title'),
    (new TextField('description'))->setTitle('Description of Award'),
    (new DateField('obtained'))->setFormat('M Y')->setTitle('Date Obtained'),
    (new EditButton)->setRouteName('politician:profile:award'),
    new DeleteButton,
    new CreateButton,
], $records))->setHeading(__('My Awards'));
?>

<?= $this->Component->render($listing) ?>
