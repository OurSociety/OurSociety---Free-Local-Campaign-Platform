<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Question[]|\Cake\Collection\CollectionInterface $questions
 * @var \OurSociety\Model\Entity\User $currentUser
 * @var int $levelQuestionTotal The total number of questions in this level.
 * @var \OurSociety\Model\Entity\ValueMatch $politicianMatch
 */
$percentage = round(($currentUser->answer_count / $levelQuestionTotal) * 100);
$ceilingReached = $percentage === 100.0;
?>

<ol class="breadcrumb">
    <li><?= $this->Html->link(__('Citizen Dashboard'), ['_name' => 'citizen:dashboard']) ?></li>
</ol>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('What should OurSociety be thinking about?') ?></h3>
    </div>
    <div class="panel-body">
        <p>
            <?= __('You have answered {answer_count} out of {question_total} questions.', [
                'answer_count' => $currentUser->answer_count,
                'question_total' => $levelQuestionTotal,
            ]) ?>
            <?php if ($ceilingReached === true): ?>
                <?= __('You have answered the first level of questions. Come back soon for more!') ?>
            <?php else: ?>
                <?= __('Keep answering to improve the accuracy of your matches!') ?>
            <?php endif ?>
        </p>

        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="<?= $percentage ?>"
                 aria-valuemin="0" aria-valuemax="100" style="min-width: <?= $percentage ?>em;">
                <?= $percentage ?>%
            </div>
        </div>

        <div class="media">
            <?php if ($politicianMatch !== null): ?>
                <div class="media-left">
                    <?= $this->cell('Profile/Picture', [], ['user' => $politicianMatch->politician]) ?>
                </div>
            <?php endif ?>
            <div class="media-body">
                <div class="col-sm-6">
                    <?php if ($politicianMatch !== null): ?>
                        <h4 class="media-heading"><?= $this->Html->politicianLink($politicianMatch->politician) ?></h4>
                        <p>
                            <?= __('Based on your answers so far, you are an {percentage_match}% match with {politician_name}.', [
                                'percentage_match' => $politicianMatch->true_match_percentage,
                                'politician_name' => $this->Html->politicianLink($politicianMatch->politician),
                            ]) ?>
                        </p>
                    <?php endif ?>
                </div>
                <div class="col-sm-6">
                    <?= $this->Html->link(
                        __('Answer some more questions!'),
                        ['_name' => 'citizen:questions'],
                        ['class' => ['btn', 'btn-primary', 'btn-block', $ceilingReached ? 'disabled' : null]]
                    ) ?>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('What should OurSociety be thinking about?') ?></h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <p>
                    OurSociety functions best when our thoughts and ideas are challenged to grow.
                    We'll pick the best questions and ask candidates with opposing viewpoints to debate the topic.
                </p>
                <p>
                    We encourage thoughtful questions about problems our society is facing.
                    Please include any source/reference data you feel would contribute to the dialogue.
                </p>
                <p>
                    Click here to view the latest debate.
                </p>
            </div>
            <div class="col-md-6">
                <?= $this->Form->create() ?>
                <?= $this->Form->control('suggestion', [
                    'type' => 'textarea',
                    'label' => false,
                    'placeholder' => <<<TEXT
Type your question here!

Be sure to read the participation guidelines!
TEXT
                ]) ?>
                <?= $this->Form->submit('Submit your question', ['class' => 'btn-primary pull-right', 'disabled' => true]) ?>
                <p class="small text-muted">
                    Read our
                    <?= $this->Html->link('participation guidelines', '#', ['class' => 'disabled']) ?>
                    here
                </p>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
