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
 * @var \OurSociety\Model\Entity\Position[]|\Cake\Datasource\ResultSetInterface $records
 */

$this->Breadcrumbs->add(__('My Dashboard'), $identity->getDashboardRoute());
$this->Breadcrumbs->add(__('My Profile'), $identity->getProfileRoute());
$this->Breadcrumbs->add(__('My Positions'));

$listing = (new Listing([
    (new TextField('name'))->setTitle('Position Title'),
    (new TextField('company'))->setTitle('Company Name'),
    (new DateField('started'))->setFormat('M Y')->setTitle('Date Started'),
    (new DateField('ended'))->setFormat('M Y')->setEmptyPlaceholder('Currently Attending')->setTitle('Date Ended'),
    (new EditButton)->setRouteName('politician:profile:position'),
    new DeleteButton,
    new CreateButton,
], $records))->setHeading(__('My Positions'));
?>

<?= $this->Component->render($listing) ?>
