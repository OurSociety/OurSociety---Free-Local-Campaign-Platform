<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $identity
 */

$this->Breadcrumbs->add(__('My Dashboard'), $identity->getDashboardRoute());
$this->Breadcrumbs->add(__('My Voice'));

$this->extend('/Common/Questions/index');
$this->assign('introduction', 'By answering the following {count} questions, we can let you know which politicians in your area agree with you.');
