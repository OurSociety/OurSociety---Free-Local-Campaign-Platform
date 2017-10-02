<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\User $politician The politician.
 */
?>

<div class="media">
    <div class="media-body">
        <h4 class="media-heading">
            <?= __('Awards') ?>
            <?= $this->fetch('actions_awards') ?>
        </h4>
        <?php if (count($politician->awards) === 0): ?>
            <p><?= __("This {role} hasn't added any awards.", ['role' => $politician->role]) ?></p>
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
