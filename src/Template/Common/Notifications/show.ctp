<?php

use OurSociety\View\Component\Detail\Show;
use OurSociety\View\Component\Field\{
    DateField, TextField
};

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Notification $record
 * @var \OurSociety\Model\Entity\User $identity
 */

$this->Breadcrumbs->add(__('My Dashboard'), $identity->getDashboardRoute());
$this->Breadcrumbs->add(__('My Notifications'), $identity->getNotificationsRoute());
?>

<?= $this->Component->render(new Show($record, [
    new DateField('created', ['title' => 'Date']),
    new TextField('title'),
    new TextField('body'),
])) ?>
