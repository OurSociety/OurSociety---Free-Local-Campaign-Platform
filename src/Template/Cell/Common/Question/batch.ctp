<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Question[]|\Cake\Collection\Collection $questions
 */
?>
<?= $this->Form->create($questions, [
    'context' => [
        'validator' => [
            'Questions' => 'default',
            'Answers' => 'default',
        ],
    ],
]) ?>
<?php foreach ($questions as $index => $question): ?>
    <?= $this->cell('Common/Question', ['question' => $question, 'number' => $index + 1]) ?>
    <?php if ($index + 1 !== count($questions)): ?>
        <hr>
    <?php endif ?>
<?php endforeach ?>
<?= $this->Form->submit('Submit your voice', ['class' => ['btn-primary', 'pull-right', 'mt-3']]) ?>
<?= $this->Form->end() ?>
