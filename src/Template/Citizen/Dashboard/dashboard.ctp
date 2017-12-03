<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Question[]|\Cake\Collection\CollectionInterface $questions
 * @var \OurSociety\Model\Entity\User $identity
 * @var int $levelQuestionTotal The total number of questions in this level.
 * @var \OurSociety\Model\Entity\ValueMatch $politicianMatch
 */
?>

<?= $this->element('Widgets/Dashboard/Citizen/values') ?>

<div class="card-deck">
    <?= $this->element('Widgets/Dashboard/Citizen/municipality') ?>
    <?= ''// $this->element('Widgets/Dashboard/Citizen/ballot')   ?>
</div>

<?= $this->element('Widgets/Dashboard/Citizen/submission') ?>
