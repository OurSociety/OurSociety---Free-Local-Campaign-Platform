<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\User $politician The politician.
 */
?>

<div class="media">
    <div class="media-body">
        <div class="row">
            <div class="col">
                <h4 class="media-heading">
                    <?= __('Born') ?>
                </h4>
            </div>
            <div class="col-auto">
                <?= $this->fetch('actions_born') ?>
            </div>
        </div>
        <p>
            <?= $politician->birth_name ?: $this->Html->tag('span', __('Unknown Birth Name'), ['class' => 'text-muted']) ?>
            <br>
            <?php if ($politician->born): ?>
                <?= $politician->born->toFormattedDateString() ?>
                <span class="text-muted small">
                    (<?= __('{age} years old', ['age' => $politician->age]) ?>)
                </span>
            <?php else: ?>
                <span class="text-muted"><?= __('Unknown Date of Birth') ?></span>
            <?php endif ?>
            <br>
            <?= __('{city}, {state}, {country}', [
                'city' => $politician->birth_city ?: $this->Html->tag('span', __('Unknown City'), ['class' => 'text-muted']),
                'state' => $politician->birth_state ?: $this->Html->tag('span', __('Unknown State'), ['class' => 'text-muted']),
                'country' => $politician->birth_country ?: $this->Html->tag('span', __('Unknown Country'), ['class' => 'text-muted']),
            ]) ?>
        </p>
    </div>
</div>
