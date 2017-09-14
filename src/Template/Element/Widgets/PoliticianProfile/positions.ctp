<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\User $politician The politician.
 */
?>

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
