<?php

use OurSociety\View\Component\Layout\ProgressBar;

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $identity
 * @var int $questionCount The number of questions.
 * @var \OurSociety\Model\Entity\ValueMatch $politicianMatch
 */

$percentage = round(($identity->answer_count / $questionCount) * 100);
$isAllAnswered = $identity->answer_count === $questionCount;

$levelBadgeImage = $this->Html->image($identity->level_badge_url, [
    'class' => ['d-flex', 'mr-3'],
    'alt' => __('Badge for level {name}', ['name' => $identity->level_name]),
]);

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
                        <?= __('You are currently on level {number}.', ['number' => $identity->level]) ?>
                    </div>
                </div>

            </div>

            <div class="col">
                <p>
                    <?= __('You have answered {answer_count} out of {question_total} questions.', [
                        'answer_count' => $identity->answer_count,
                        'question_total' => $questionCount,
                    ]) ?>
                    <?php if ($isAllAnswered === true): ?>
                        <?= __('You have answered all the questions. We will let you know if we add more in the future!') ?>
                    <?php else: ?>
                        <?= __('Keep answering to improve the accuracy of your matches!') ?>
                    <?php endif ?>
                </p>

                <?= $this->Component->render(new ProgressBar($percentage)) ?>

                <div class="row mt-3">
                    <div class="col">
                        <?= $this->Html->link(
                            __('Answer some more questions!'),
                            ['_name' => 'citizen:questions'],
                            ['class' => ['btn', 'btn-primary', 'btn-block', $isAllAnswered ? 'disabled' : null]]
                        ) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

