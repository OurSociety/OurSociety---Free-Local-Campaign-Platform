<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Question $question The question being asked.
 * @var \OurSociety\Model\Entity\User $identity The currently authenticated user.
 * @var int $number The question number in the current batch of questions.
 */

use Cake\Utility\Text;
use OurSociety\Model\Entity\Answer;

$index = isset($number) ? $number - 1 : null;

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

$getFieldName = function (string $fieldName, int $index = null): string {
    if ($index === null) {
        return $fieldName;
    }

    return sprintf('%d.answers.0.%s', $index, $fieldName);
};

$importanceError = $getError($question, 'importance');
$answerError = $getError($question, 'answer');
?>
<div class="row">
    <div class="col-md-6">
        <div class="row text-primary">
            <div class="col-sm-auto order-sm-12 text-center"
                 title="Category: <?= $question->category->name ?>">
                <?= $this->Html->icon(
                    $question->category->slug,
                    ['iconSet' => 'topic', 'height' => 100, 'width' => 100]
                ) ?>
                <p class="small mb-0" style="margin-top: -1rem; max-width: 8rem;">
                    <?= $question->category->name ?>
                </p>
            </div>
            <div class="col-sm">
                <blockquote class="blockquote">
                    <?= $question->printQuestion() ?>
                </blockquote>
            </div>
        </div>
        <hr>
        <fieldset class="form-question-importance">
            <legend><?= __('How important is this topic to you?') ?></legend>
            <div <?= $importanceError !== null ? ' class="has-error"' : null ?>>
                <?= $importanceError ?>
                <?= $this->Form->control($getFieldName('importance', $index), [
                    'default' => $index ? null : $answer->importance,
                    'inline' => true,
                    'required' => false,
                    'label' => false,
                    'type' => 'radio',
                    'class' => ['has-error'],
                    'options' => Answer::IMPORTANCE,
                ]) ?>
            </div>
        </fieldset>
    </div>
    <div class="col-md-6 form-question-answers">
        <?php if ($question->type === null): ?>
            Unknown question type.
        <?php else: ?>
            <?php if ($index !== null): ?>
                <?= $this->Form->hidden(sprintf('%d.id', $index), ['value' => $question->id]) ?>
            <?php endif ?>
            <?= $this->Form->hidden($getFieldName('id', $index), ['value' => Text::uuid()]) ?>
            <?= $this->Form->hidden($getFieldName('question_id', $index), ['value' => $question->id]) ?>
            <?= $this->Form->hidden($getFieldName('user_id', $index), ['value' => $identity->id]) ?>
            <div <?= $answerError !== null ? ' class="has-error"' : null ?>>
                <?= $answerError ?>
                <?= $this->Form->control($getFieldName('answer', $index), [
                    'default' => $index ? null : $answer->answer,
                    'required' => false,
                    'label' => false,
                    'type' => 'radio',
                    'options' => $question->type === 'scale' ? Answer::ANSWERS_SCALE : Answer::ANSWERS_BOOL,
                ]) ?>
            </div>
        <?php endif ?>
    </div>
</div>
