<?php

use OurSociety\View\Component\Field\{
    DateField, TextField
};
use OurSociety\View\Component\Listing\Listing;

/**
 * @var \OurSociety\View\AppView $this
 * @var \Cake\ORM\ResultSet $records
 * @var \OurSociety\Model\Entity\User $identity
 */

$this->Breadcrumbs->add(__('My Dashboard'), $identity->getDashboardRoute());
$this->Breadcrumbs->add(__('My Voice'), ['_name' => 'citizen:questions']);
?>

<?= $this->Component->render(new Listing([
    new DateField('created', ['title' => 'Date']),
    new TextField('question.question', ['title' => 'Question']),
    new TextField('answer_text', ['title' => 'Answer']),
    new TextField('importance_text', ['title' => 'Importance']),
], $records)) ?>
