<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Question[]|\Cake\Collection\CollectionInterface $questions
 * @var \OurSociety\Model\Entity\User $politician The currently viewed politician.
 * @var \OurSociety\Model\Entity\User $currentUser The currently authenticated user.
 * @var \OurSociety\View\Cell\Profile\PictureCell $picture The profile picture cell.
 * @var \OurSociety\View\Cell\Profile\ValueMatchCell $valueMatch The value match cell.
 * @var bool $edit True if editing profile, false otherwise.
 */

$email = $politician->verified === null ? $politician->email : $politician->email_temp;
?>

<?= $this->fetch('breadcrumbs') ?>

<h2>
    <?= $politician->name ?>
    <div class="pull-right">
        <?= $this->fetch('actions_heading') ?>
    </div>
</h2>

<hr>

<section>
    <div class="row text-center">
        <div class="col-sm-4">
            <?= $this->fetch('profile_picture') ?>
            <p><?= $politician->phone ?></p>
            <p><?= $this->Html->link($email, sprintf('mailto:%s', $email)) ?></p>
        </div>
        <div class="col-sm-8">
            <?= $this->cell('Profile/ValueMatch', [$politician, $currentUser]) ?>
        </div>
    </div>
</section>

<hr>

<section>
    <h3>
        <?= __('My platform') ?>
        <?= $this->fetch('actions_videos') ?>
        <?= $this->fetch('actions_articles') ?>
    </h3>
    <div class="row">
        <div class="col-md-6 text-center">
            <?php if ($politician->featured_video === null): ?>
                <p><?= __("This politician hasn't featured a YouTube video.") ?></p>
            <?php else: ?>
                <?= $this->Video->embed(
                    $politician->featured_video->youtube_video_url,
                    ['width' => '100%', 'height' => 300, 'failSilently' => true]) ?>
            <?php endif ?>
            <?php if (count($politician->videos) === 0): ?>
                <p class="text-muted small"><?= __("This politician hasn't linked any additional YouTube videos.") ?></p>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($politician->videos as $video): ?>
                        <div class="col-md-2">
                            <?= $this->Html->image(
                                $video->youtube_video_thumbnail,
                                ['class' => ['img-responsive'], 'style' => 'margin: 0 auto']) ?>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>
        <div class="col-md-6" id="articles">
            <?php if (count($politician->articles) === 0): ?>
                <p><?= __("This politician hasn't posted any articles.") ?></p>
            <?php else: ?>
                <?php foreach ($politician->articles as $article): ?>
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading">
                                <?php if ($this->request->getParam('prefix') === 'politician'): ?>
                                    <?= $this->Html->link($article->name, [
                                        'prefix' => 'politician/profile',
                                        'controller' => 'Articles',
                                        'action' => 'view',
                                        $article->id,
                                    ]) ?>
                                <?php else: ?>
                                    <?= $this->Html->link($article->name, [
                                        '_name' => 'politician:article',
                                        'politician' => $politician->slug,
                                        'article' => $article->slug,
                                    ]) ?>
                                <?php endif ?>
                                <span class="text-muted small">
                                    <?= $article->published
                                        ? $article->published->toFormattedDateString()
                                        : __('Unpublished') ?>
                                </span>
                            </h4>
                            <p><?= $this->Text->truncate($article->body, 360, ['html' => true]) ?></p>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</section>

<hr>

<section>
    <h3><?= __('About {name}',  ['name' => $this->request->getParam('id') ? $politician->name : __('me')]) ?></h3>
    <div class="row">
        <div class="col-md-8">
            <div class="media">
                <div class="media-body">
                    <h4 class="media-heading">
                        <?= __('Positions') ?>
                        <?= $this->fetch('actions_positions') ?>
                    </h4>
                    <?php if (count($politician->positions) === 0): ?>
                        <p><?= __("This politician hasn't added any positions.") ?></p>
                    <?php else: ?>
                        <ul>
                            <?php foreach ($politician->positions as $position): ?>
                                <li>
                                    <strong><?= $position->name ?></strong>,
                                    <?= $position->company ?>
                                    <span class="text-muted small">
                                        <?= sprintf(
                                            '%s–%s',
                                            $position->started->toFormattedDateString(),
                                            $position->ended ? $position->ended->toFormattedDateString() : 'Present'
                                        ) ?>
                                    </span>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    <?php endif ?>
                </div>
            </div>
            <div class="media">
                <div class="media-body">
                    <h4 class="media-heading">
                        <?= __('Education') ?>
                        <?= $this->fetch('actions_education') ?>
                    </h4>
                    <?php if (count($politician->qualifications) === 0): ?>
                        <p><?= __("This politician hasn't added any qualifications.") ?></p>
                    <?php else: ?>
                        <ul>
                            <?php foreach ($politician->qualifications as $qualification): ?>
                                <li>
                                    <strong><?= $qualification->name ?></strong>,
                                    <?= $qualification->institution ?>
                                    <span class="text-muted small">
                                        <?= sprintf(
                                            '%s–%s',
                                            $qualification->started->toFormattedDateString(),
                                            $qualification->ended ? $qualification->ended->toFormattedDateString() : 'Present'
                                        ) ?>
                                    </span>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    <?php endif ?>
                </div>
            </div>
            <div class="media">
                <div class="media-body">
                    <h4 class="media-heading">
                        <?= __('Awards') ?>
                        <?= $this->fetch('actions_awards') ?>
                    </h4>
                    <?php if (count($politician->awards) === 0): ?>
                        <p><?= __("This politician hasn't added any awards.") ?></p>
                    <?php else: ?>
                        <ul>
                            <?php foreach ($politician->awards as $award): ?>
                                <li>
                                    <strong><?= $award->name ?></strong>
                                    <span class="text-muted small">
                                        <?= $award->obtained->toFormattedDateString() ?>
                                    </span>
                                    <?= $award->description ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="media">
                <div class="media-body">
                    <h4 class="media-heading">
                        <?= __('Born') ?>
                        <?= $this->fetch('actions_born') ?>
                    </h4>
                    <p>
                        <?= $politician->birth_name ?: $this->Html->tag('span', __('Unknown'), ['class' => 'text-muted']) ?>
                        <br>
                        <?= $politician->born
                            ? $politician->born->toFormattedDateString()
                            : $this->Html->tag('span', __('Unknown'), ['class' => 'text-muted']) ?>
                        <span class="text-muted small">
                            (<?= __('{age} years old', ['age' => $politician->age])?>)
                        </span>
                        <br>
                        <?= __('{city}, {state}, {country}', [
                            'city' => $politician->birth_city ?: $this->Html->tag('span', __('Unknown'), ['class' => 'text-muted']),
                            'state' => $politician->birth_state ?: $this->Html->tag('span', __('Unknown'), ['class' => 'text-muted']),
                            'country' => $politician->birth_country ?: $this->Html->tag('span', __('Unknown'), ['class' => 'text-muted']),
                        ])?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
