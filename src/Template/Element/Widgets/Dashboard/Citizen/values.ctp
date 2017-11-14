<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $identity
 * @var int $levelQuestionTotal The total number of questions in this level.
 * @var \OurSociety\Model\Entity\ValueMatch $politicianMatch
 */

use Cake\I18n\Date;

$levelNumber = $identity->level ?? 1;
$percentage = round(($identity->answer_count / $levelQuestionTotal) * 100);
$ceilingReached = $levelNumber === 10 && $percentage === 100.0;
?>

<div class="card mb-3">
    <h4 class="card-header">
        <?= __('My Values') ?>
    </h4>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">

                <div class="media">
                    <?= $this->Html->image($identity->level_badge_url, [
                        'class' => ['d-flex', 'mr-3'],
                        'alt' => __('Badge for level {name}', ['name' => $identity->level_name]),
                    ]) ?>

                    <div class="media-body">
                        <h5 class="mt-0"><?= $identity->level_name ?></h5>
                        You are currently on level <?= $levelNumber ?>.
                    </div>
                </div>

            </div>
            <div class="col">

                <p>
                    <?= __('You have answered {answer_count} out of {question_total} questions.', [
                        'answer_count' => $identity->answer_count,
                        'question_total' => $levelQuestionTotal,
                    ]) ?>
                    <?php if ($ceilingReached === true): ?>
                        <?= __('You have answered the first level of questions. Come back soon for more!') ?>
                    <?php else: ?>
                        <?= __('Keep answering to improve the accuracy of your matches!') ?>
                    <?php endif ?>
                </p>

                <div class="progress" style="height: 25px;">
                    <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="<?= $percentage ?>"
                         aria-valuemin="0" aria-valuemax="100" style="width: <?= $percentage ?>%;">
                        <?= $percentage ?>%
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <?php if ($politicianMatch !== null && Date::now()->year >= 2018): ?>
                            <?php
                            $politician = $politicianMatch->politician;
                            $profileLink = $this->Html->link($politician->name, $politician->getPublicProfileRoute());
                            ?>
                            <div class="media">
                                <div class="media-left pr-2">
                                    <?= $politician->renderProfilePicture($this, [
                                        'class' => 'img-thumbnail',
                                        'style' => 'max-height: 100px',
                                    ]) ?>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <?= $profileLink ?>
                                    </h4>
                                    <p>
                                        <?= __('Based on your answers so far, you are an {percentage_match}% match with {politician_name}.', [
                                            'percentage_match' => $politicianMatch->true_match_percentage,
                                            'politician_name' => $profileLink,
                                        ]) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="col">
                        <div class="btn-group">
                            <?= $this->Html->link(__('Review Past Answers'), ['_name' => 'citizen:answers'], [
                                'class' => [
                                    'btn',
                                    'btn-link',
                                    $identity->answer_count === 0 ? 'disabled' : null,
                                ],
                            ]) ?>
                            <?= $this->Html->link(__('Answer some more questions!'), ['_name' => 'citizen:questions'], [
                                'class' => [
                                    'btn',
                                    'btn-primary',
                                    'rounded-left',
                                    $ceilingReached ? 'disabled' : null,
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
