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
?>
<ol class="breadcrumb">
    <li><?= $this->Html->dashboardLink() ?></li>
    <li><?= $this->Html->link('Politicians', ['_name' => 'citizen:politicians']) ?></li>
    <li><?= $politician->name ?></li>
</ol>

<h2>
    <?= $politician->name ?>
    <?php if ($currentUser->isPolitician()): ?>
        <?= $this->Html->link('Edit profile', ['_name' => 'politician:profile:edit'], ['class' => 'btn btn-default']) ?>
    <?php endif ?>
</h2>

<hr>

<section>
    <div class="row text-center">
        <div class="col-sm-4">
            <?= $this->cell('Profile/Picture', [], ['user' => $currentUser]) ?>
            <p><?= $politician->phone ?></p>
            <p><?= $this->Html->link($politician->email, sprintf('mailto:%s', $politician->email)) ?></p>
        </div>
        <div class="col-sm-8">
            <?= $this->cell('Profile/ValueMatch', [$politician, $currentUser]) ?>
        </div>
    </div>
</section>

<hr>

<section>
    <h3>My platform</h3>
    <div class="row">
        <div class="col-md-6 text-center">
            <?php if ($politician->featured_video === null): ?>
                <p>This politician hasn't featured a YouTube video.</p>
            <?php else: ?>
                <?= $this->Video->embed(
                    $politician->featured_video->youtube_video_url,
                    ['width' => '100%', 'height' => 300, 'failSilently' => true]) ?>
            <?php endif ?>
            <?php if (count($politician->videos) === 0): ?>
                <p class="text-muted small">This politician hasn't linked any additional YouTube videos.</p>
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
            <?php if ($currentUser->isPolitician()): ?>
                <?= $this->Html->link('Edit Videos', ['_name' => 'politician:profile:videos'], ['class' => 'btn btn-default']) ?>
            <?php endif ?>
        </div>
        <div class="col-md-6" id="articles">
            <?php if (count($politician->articles) === 0): ?>
                <p>This politician hasn't posted any articles.</p>
            <?php else: ?>
                <?php foreach ($politician->articles as $article): ?>
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading">
                                <?= $this->Html->link($article->name, [
                                    '_name' => 'citizen:politician:article',
                                    'politician' => $politician->slug,
                                    'article' => $article->slug,
                                ]) ?>
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
            <?php if ($currentUser->isPolitician()): ?>
                <?= $this->Html->link('Post Articles', ['_name' => 'politician:profile:articles'], ['class' => 'btn btn-default']) ?>
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
                        <?php if ($currentUser->isPolitician()): ?>
                            <?= $this->Html->link('Edit Positions', ['_name' => 'politician:profile:positions'], ['class' => 'btn btn-default']) ?>
                        <?php endif ?>
                    </h4>
                    <?php if (count($politician->positions) === 0): ?>
                        <p>This politician hasn't added any positions.</p>
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
                        <?php if ($currentUser->isPolitician()): ?>
                            <?= $this->Html->link('Edit Qualifications', ['_name' => 'politician:profile:qualifications'], ['class' => 'btn btn-default']) ?>
                        <?php endif ?>
                    </h4>
                    <?php if (count($politician->qualifications) === 0): ?>
                        <p>This politician hasn't added any qualifications.</p>
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
                        <?php if ($currentUser->isPolitician()): ?>
                            <?= $this->Html->link('Edit Awards', ['_name' => 'politician:profile:awards'], ['class' => 'btn btn-default']) ?>
                        <?php endif ?>
                    </h4>
                    <?php if (count($politician->awards) === 0): ?>
                        <p>This politician hasn't added any awards.</p>
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
                        <?php if ($currentUser->isPolitician()): ?>
                            <?= $this->Html->link('Edit profile', ['_name' => 'politician:profile:edit'], ['class' => 'btn btn-default']) ?>
                        <?php endif ?>
                    </h4>
                    <p>
                        <?= $politician->birth_name ?>
                        <br>
                        <?= $politician->born
                            ? $politician->born->toFormattedDateString()
                            : __('Unknown') ?>
                        <span class="text-muted small">
                            (<?= __('{age} years old', ['age' => $politician->age])?>)
                        </span>
                        <br>
                        <?= __('{city}, {state}, {country}', [
                            'city' => $politician->birth_city,
                            'state' => $politician->birth_state,
                            'country' => $politician->birth_country,
                        ])?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
