<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $currentUser
 * @var int $levelQuestionTotal The total number of questions in this level.
 * @var \OurSociety\Model\Entity\ValueMatch $politicianMatch
 */
$levelMap = [
    1 => ['name' => 'Citizen', 'image' => '/img/svg/badge/01-citizen.svg'],
    2 => ['name' => 'Member', 'image' => '/img/svg/badge/02-member.svg'],
    3 => ['name' => 'Participant', 'image' => '/img/svg/badge/03-participant.svg'],
    4 => ['name' => 'Informed Voter', 'image' => '/img/svg/badge/04-informed-voter.svg'],
    5 => ['name' => 'Community Advocate', 'image' => '/img/svg/badge/05-community-advocate.svg'],
    6 => ['name' => 'Community Champion', 'image' => '/img/svg/badge/06-community-champion.svg'],
    7 => ['name' => 'Community Builder', 'image' => '/img/svg/badge/07-community-builder.svg'],
    8 => ['name' => 'Thought Leader', 'image' => '/img/svg/badge/08-thought-leader.svg'],
    9 => ['name' => 'Visionary Citizen', 'image' => '/img/svg/badge/09-visionary-citizen.svg'],
    10 => ['name' => 'Enlightened Citizen', 'image' => '/img/svg/badge/10-enlightened-citizen.svg'],
];
$levelNumber = $currentUser->level ?? 1;
$level = $levelMap[$levelNumber];
$percentage = round(($currentUser->answer_count / $levelQuestionTotal) * 100);
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
                    <img class="d-flex mr-3" src="<?= $level['image'] ?>" alt="Badge">
                    <div class="media-body">
                        <h5 class="mt-0"><?= $level['name'] ?></h5>
                        You are currently on level <?= $levelNumber ?>.
                    </div>
                </div>

            </div>
            <div class="col">

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

                <div class="progress" style="height: 25px;">
                    <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="<?= $percentage ?>"
                         aria-valuemin="0" aria-valuemax="100" style="width: <?= $percentage ?>%;">
                        <?= $percentage ?>%
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <?php if ($politicianMatch !== null): ?>
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
</div>
