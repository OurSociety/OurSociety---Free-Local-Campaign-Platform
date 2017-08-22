<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User|null $currentUser The currently logged in user, if any.
 * @var \OurSociety\Model\Entity\User $politician The currently viewed politician.
 */
?>

<h1 class="display-4">
    <?= $politician->name ?>
</h1>

<p class="lead">
    <?php if (!$politician->incumbent): ?>
        <?= __('Running for') ?>
    <?php endif ?>
    <?= $politician->position ?>
</p>

<?= $this->Html->image($politician, [
    'alt' => __('Profile picture of {user_name}', ['user_name' => $politician->name]),
    'class' => ['img-responsive'], 'style' => 'max-height: 200px',
]) ?>

<hr>

<h2>
    <?= __('My Platform') ?>
</h2>

<div class="row">
    <?php if (count($politician->videos) === 0): ?>
        <div class="col">
            <?= $politician->featured_video->renderEmbed($this) ?>
        </div>
    <?php else: ?>
        <div class="col">
            <?= $politician->featured_video->renderEmbed($this) ?>
        </div>
        <div class="col">
            <?= $politician->videos[0]->renderEmbed($this) ?>
        </div>
    <?php endif ?>
</div>

<hr>

<?php if (count($politician->articles) > 0): ?>
    <h3>
        <?= __('Articles') ?>
    </h3>
    <?php foreach (collection($politician->articles)->take(3) as $article): ?>
        <p class="lead">
            <span class="text-muted"><?= $article->published->toFormattedDateString() ?> &ndash;</span>
            <?= $article->name ?>
        </p>
    <?php endforeach ?>
<?php endif ?>

<hr>

<h3>
    <?= __('About me') ?>
</h3>

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

<?php if (count($politician->positions) > 0): ?>
    <ul>
        <?php foreach ($politician->positions as $position): ?>
            <li>
                <strong><?= $position->name ?></strong>,
                <?= $position->company ?>
                <span class="text-muted small">
                    <?= sprintf(
                        '%s–%s',
                        $position->started->format('M Y'),
                        $position->ended ? $position->ended->format('M Y') : 'Present'
                    ) ?>
                </span>
            </li>
        <?php endforeach ?>
    </ul>
<?php endif ?>

<?php if (count($politician->qualifications) > 0): ?>
    <ul>
        <?php foreach ($politician->qualifications as $qualification): ?>
            <li>
                <strong><?= $qualification->name ?></strong>,
                <?= $qualification->institution ?>
                <span class="text-muted small">
                    <?= sprintf(
                        '%s–%s',
                        $qualification->started->format('M Y'),
                        $qualification->ended ? $qualification->started->format('M Y') : 'Present'
                    ) ?>
                </span>
            </li>
        <?php endforeach ?>
    </ul>
<?php endif ?>
