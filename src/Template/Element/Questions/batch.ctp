<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Answer $answers
 * @var \OurSociety\Model\Entity\Question[]|\Cake\Collection\CollectionInterface $questions
 */
?>
<section>
    <h1>Questions</h1>
    <?= $this->Form->create($questions) ?>
    <?php foreach ($questions as $question): ?>
        <?= $this->element('Questions/single', ['question' => $question]) ?>
    <?php endforeach ?>
    <?= $this->Form->end() ?>
</section>
