<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Answer $answers
 * @var \OurSociety\Model\Entity\Question[]|\Cake\Collection\CollectionInterface $questions
 */
?>
<?= $this->Form->create($questions) ?>
<?php foreach ($questions as $index => $question): ?>
    <?= $this->element('Questions/single', ['question' => $question, 'number' => $index + 1]) ?>
<?php endforeach ?>
<?= $this->Form->submit('Submit your voice', ['class' => ['btn-primary', 'pull-right']]) ?>
<?= $this->Form->end() ?>

<br>
<br>
