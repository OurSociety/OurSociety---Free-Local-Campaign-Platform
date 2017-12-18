<?php

use OurSociety\View\Component\Layout\ProgressBar;

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $identity
 * @var int $levelQuestionTotal The total number of questions in this level.
 * @var \OurSociety\Model\Entity\ValueMatch $politicianMatch
 */

$levelNumber = $identity->level ?? 1;
$percentage = round(($identity->answer_count / $levelQuestionTotal) * 100);
$ceilingReached = $levelNumber === 10 && $percentage === 100.0;

$levelBadgeImage = $this->Html->image($identity->level_badge_url, [
    'class' => ['d-flex', 'mr-3'],
    'alt' => __('Badge for level {name}', ['name' => $identity->level_name]),
]);
$answerQuestionsButton = $this->Html->link(__('Answer questions!'), ['_name' => 'citizen:questions'], [
    'class' => ['btn', 'btn-primary', 'btn-block', $ceilingReached ? 'disabled' : null],
]);
$reviewAnswersButton = $this->Html->link(__('Review Answers'), ['_name' => 'citizen:answers'], [
    'class' => ['btn', 'btn-link', 'btn-block', $identity->answer_count === 0 ? 'disabled' : null],
]);
$valueMatchCard = $politicianMatch->renderCardElement($this);
?>

<div class="card mb-3">
    <h4 class="card-header">
        <?= __('My Societal Values') ?>
    </h4>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4">

                <div class="media">
                    <?= $levelBadgeImage ?>

                    <div class="media-body">
                        <h5 class="mt-0"><?= $identity->level_name ?></h5>
                        <?= __('You are currently on level {number}.', ['number' => $levelNumber]) ?>
                    </div>
                </div>

            </div>
            <div class="col">

                <?= $this->Component->render(new ProgressBar($percentage)) ?>

                <p>
                    <?= __('You have answered {answer_count} questions.', [
                        'answer_count' => $identity->answer_count,
                    ]) ?>
                    <?php if ($ceilingReached === true): ?>
                        <?= __('You have answered the first level of questions. Come back soon for more!') ?>
                    <?php else: ?>
                        <?= __('Keep answering to improve the accuracy of your value matches!') ?>
                    <?php endif ?>
                </p>

                <div class="row">
                    <div class="col-md order-md-11">
                        <?= $answerQuestionsButton ?>
                    </div>
                    <div class="col-md order-md-1">
                        <?= $reviewAnswersButton ?>
                    </div>
                </div>

                <?php /*
                <div class="row mt-3">
                    <div class="col-md">
                        <?= $valueMatchCard ?>
                    </div>
                    <div class="col-md">
                    </div>
                </div>
                */ ?>

            </div>
        </div>
    </div>
</div>
