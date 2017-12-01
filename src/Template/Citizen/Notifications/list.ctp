<?php

use OurSociety\View\Component\Button\ShowButton;
use OurSociety\View\Component\Field\{
    BooleanDateField, DateField, TextField
};
use OurSociety\View\Component\Listing\Listing;

/**
 * @var \OurSociety\View\AppView $this
 * @var \Cake\ORM\ResultSet $records
 * @var \OurSociety\Model\Entity\User $identity
 */

$this->Breadcrumbs->add(__('My Dashboard'), $identity->getDashboardRoute());
$this->Breadcrumbs->add(__('My Notifications'), $identity->getNotificationsRoute());
?>

<?= $this->Component->render(new Listing([
    new DateField('created', ['title' => 'Date']),
    new TextField('title'),
    new BooleanDateField('seen', ['title' => 'Read']),
    new ShowButton(),
], $records)) ?>
