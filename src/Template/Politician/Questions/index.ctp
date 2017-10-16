<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $currentUser
 */
$this->extend('/Common/Questions/index');

$this->Breadcrumbs->add(__('My Dashboard'), $currentUser->getDashboardRoute());
$this->Breadcrumbs->add(__('Profile'), $currentUser->getProfileRoute());
$this->Breadcrumbs->add(__('My Voice'));

$this->start('actions');
echo $this->Html->link(__('View Profile'), ['_name' => 'politician:profile'], ['class' => ['btn btn-default pull-right']]);
$this->end();

$this->assign('introduction', 'By answering the following {count} questions, we can let citizens in your area know if they agree with you.');
