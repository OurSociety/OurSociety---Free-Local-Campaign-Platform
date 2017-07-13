<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Question[]|\Cake\Collection\CollectionInterface $questions
 */
?>
<h1>Citizen Dashboard</h1>
<div class="jumbotron"></div>

<?= $this->element('Questions/batch', ['questions' => $questions]) ?>
