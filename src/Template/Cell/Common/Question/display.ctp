<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Question $question The question being asked.
 * @var \OurSociety\Model\Entity\User $identity The currently authenticated user.
 * @var int $number The question number in the current batch of questions.
 * @var bool $showAnswerLater Whether to show the "Answer Later" link or not.
 */

$cardTitle = $number ? __('Question #{number}', ['number' => $number]) : __('Question');
$domId = $number ? sprintf('question-%d', $number) : 'question';
$showAnswerLater = isset($number);
?>
<article class="card card-default js-question">
    <div class="card-header">
        <div class="row">
            <h4 class="col mb-0"><?= $cardTitle ?></h4>
            <?php if ($showAnswerLater === true): ?>
                <div class="col-auto text-muted">
                    <?= $this->Html->link(__('Answer Later'), sprintf('#%s', $domId), [
                        'aria-controls' => $domId,
                        'class' => ['js-question-link', 'btn', 'btn-link', 'text-secondary', 'p-0'],
                        'data-toggle' => 'collapse',
                    ]) ?>
                </div>
            <?php endif ?>
        </div>
    </div>
    <div class="card-collapse collapse show" id="<?= $domId ?>" aria-expanded="true">
        <div class="card-body">
            <?= $this->element('Form/question') ?>
        </div>
        <div class="card-footer small">
            <?= $this->Html->link(
                __('Report this question'),
                ['controller' => 'Reports', 'action' => 'add', '?' => ['question_id' => $question->id]],
                ['class' => 'text-muted', 'target' => '_blank']
            ) ?>
        </div>
    </div>
</article>
