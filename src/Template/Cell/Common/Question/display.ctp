<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Question $question The question being asked.
 * @var \OurSociety\Model\Entity\User $currentUser The currently authenticated user.
 * @var int $number The question number in the current batch of questions.
 */
use Cake\Utility\Text;
use OurSociety\Model\Entity\Answer;

$index = $number - 1;

$getError = function (\OurSociety\Model\Entity\Question $question, string $field): ?string {
    if ($question->answers === null) {
        return null;
    }

    if (count($question->answers) === 0) {
        return null;
    }

    $errors = $question->answers[0]->getError($field);

    if (count($errors) === 0) {
        return null;
    }

    return $this->Form->formatTemplate('error', ['content' => implode('', $errors)]);
};

$importanceError = $getError($question, 'importance');
$answerError = $getError($question, 'answer');
?>
<article class="card card-default js-question">
    <div class="card-header">
        <div class="row">
            <h4 class="col mb-0"><?= __('Question #{number}', ['number' => $number]) ?></h4>
            <div class="col-auto text-muted">
                <?= $this->Html->link(__('Answer Later'), sprintf('#question-%d', $number), [
                    'aria-controls' => sprintf('question-%d', $number),
                    'class' => ['js-question-link', 'btn', 'btn-link', 'text-secondary', 'p-0'],
                    'data-toggle' => 'collapse',
                ]) ?>
            </div>
        </div>
    </div>
    <div class="card-collapse collapse show" id="question-<?= $number ?>" aria-expanded="true">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-auto order-sm-12 text-center">
                            <?= $this->Html->icon(
                                $question->category->slug,
                                ['iconSet' => 'topic', 'height' => 100, 'width' => 100]
                            ) ?>
                        </div>
                        <div class="col-sm">
                            <blockquote class="blockquote">
                                <p><?= $question->question ?></p>
                                <footer class="blockquote-footer">
                                    <?= __('Category') ?>:
                                    <cite>
                                        <?= $question->category->name ?>
                                    </cite>
                                </footer>
                            </blockquote>
                        </div>
                    </div>
                    <fieldset class="form-question-importance">
                        <legend><?= __('How important is this topic to you?') ?></legend>
                        <div <?= $importanceError !== null ? ' class="has-error"' : null ?>>
                            <?= $importanceError ?>
                            <?= $this->Form->control(sprintf('%d.answers.0.importance', $index), [
                                'inline' => true,
                                'required' => false,
                                'label' => false,
                                'type' => 'radio',
                                'class' => ['has-error'],
                                'options' => Answer::IMPORTANCE
                            ]) ?>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-6 form-question-answers">
                    <?= $this->Form->hidden(sprintf('%d.id', $index), ['value' => $question->id]) ?>
                    <?= $this->Form->hidden(sprintf('%d.answers.0.id', $index), ['value' => Text::uuid()]) ?>
                    <?= $this->Form->hidden(sprintf('%d.answers.0.question_id', $index), ['value' => $question->id]) ?>
                    <?= $this->Form->hidden(sprintf('%d.answers.0.user_id', $index), ['value' => $currentUser->id]) ?>
                    <div <?= $answerError !== null ? ' class="has-error"' : null ?>>
                        <?= $answerError ?>
                        <?= $this->Form->control(sprintf('%d.answers.0.answer', $index), [
                            'required' => false,
                            'label' => false,
                            'type' => 'radio',
                            'options' => $question->type === 'scale' ? Answer::ANSWERS_SCALE : Answer::ANSWERS_BOOL
                        ]) ?>
                    </div>
                </div>
            </div>
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
