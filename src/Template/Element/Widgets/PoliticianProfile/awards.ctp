<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\User $politician The politician.
 */
?>

<div class="media" id="awards">
    <div class="media-body">
        <div class="row">
            <div class="col">
                <h4 class="media-heading">
                    <?= __('Awards') ?>
                </h4>
            </div>
            <div class="col-auto">
                <?= $this->fetch('actions_awards') ?>
            </div>
        </div>
        <?php if (count($politician->awards) === 0): ?>
            <p><?= __("This representative hasn't added any awards.") ?></p>
        <?php else: ?>
            <ul>
                <?php foreach ($politician->awards as $award): ?>
                    <li class="award award-<?= $award->getIdentifierValue() ?>">
                        <strong class="award-name"><?= $award->name ?></strong>
                        <span class="award-date text-muted small">
                            <?= $award->printObtained() ?>
                        </span>
                        <span class="award-description">
                            <?= $award->description ?>
                        </span>
                    </li>
                <?php endforeach ?>
            </ul>
        <?php endif ?>
    </div>
</div>
