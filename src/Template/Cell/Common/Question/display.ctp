<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Question $question The question being asked.
 * @var \OurSociety\Model\Entity\User $currentUser The currently authenticated user.
 * @var int $number The question number in the current batch of questions.
 */
use Cake\Utility\Text;
use OurSociety\Model\Entity\Answer;
?>
<article class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Question #{number}', ['number' => $number]) ?></h3>
    </div>
    <div class="panel-body">
        <div class="row row-md-flex-center">
            <div class="col-md-6">
                <blockquote>
                    <?= $this->Html->icon($question->category->slug, ['iconSet' => 'topic', 'height' => 100, 'width' => 100]) ?>
                    <p><?= $question->question ?></p>
                    <footer>Category: <cite><?= $question->category->name ?></cite></footer>
                </blockquote>

                <fieldset class="form-question-importance">
                    <legend><?= __('How important is this topic to you?') ?></legend>
                    <?= $this->Form->control(sprintf('%d.answers.0.importance', $number - 1), [
                        'inline' => true,
                        'required' => false,
                        'label' => false,
                        'type' => 'radio',
                        'options' => Answer::IMPORTANCE
                    ]) ?>
                </fieldset>
            </div>
            <div class="col-md-6 form-question-answers">
                <?= $this->Form->hidden(sprintf('%d.id', $number - 1), ['value' => $question->id]) ?>
                <?= $this->Form->hidden(sprintf('%d.answers.0.id', $number - 1), ['value' => Text::uuid()]) ?>
                <?= $this->Form->hidden(sprintf('%d.answers.0.question_id', $number - 1), ['value' => $question->id]) ?>
                <?= $this->Form->hidden(sprintf('%d.answers.0.user_id', $number - 1), ['value' => $currentUser->id]) ?>
                <?= $this->Form->control(sprintf('%d.answers.0.answer', $number - 1), [
                    'required' => false,
                    'label' => false,
                    'type' => 'radio',
                    'options' => $question->type === 'scale' ? Answer::ANSWERS_SCALE : Answer::ANSWERS_BOOL
                ]) ?>
            </div>
        </div>
    </div>
    <div class="panel-footer small">
        <?= $this->Html->link(__('Report this question'), '#', ['class' => 'text-muted']) ?>
    </div>
</article>
