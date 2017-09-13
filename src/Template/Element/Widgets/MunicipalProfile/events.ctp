<?php
/**
 * @var \OurSociety\View\AppView $this View class.
 * @var \OurSociety\Model\Entity\ElectoralDistrict $municipality The municipality.
 * @var \OurSociety\Model\Entity\Event[] $events The events.
 * @var \OurSociety\Model\Entity\User|null $currentUser The current user, if any.
 */

$isExample = count($events) === 0;
if ($isExample):
    $events = \OurSociety\Model\Entity\Event::examples(5);
endif;
?>

<div<?= $isExample ? ' class="example"' : null ?>>
    <div class="btn-group float-right">
        <?php if ($currentUser && $currentUser->canEditMunicipality($municipality)): ?>
            <?= $this->Html->link(
                __('Add Event'),
                ['_name' => 'municipality:events:add', 'municipality' => $municipality->slug],
                ['class' => ['btn', 'btn-sm', 'btn-outline-dark'], 'icon' => 'plus'
            ]) ?>
        <?php endif ?>
        <?= $this->Html->link(
            __('View All'),
            ['_name' => 'municipality:events', 'municipality' => $municipality->slug],
            ['class' => ['btn', 'btn-sm', 'btn-outline-dark'], 'icon' => 'list']
        ) ?>
    </div>

    <h3>
        <?= __('Upcoming Events') ?>
    </h3>

    <ul class="list-unstyled">
        <?php foreach ($events as $event): ?>
            <li class="text-truncate">
                <?= $event->renderSummaryElement($this) ?>
            </li>
        <?php endforeach ?>
    </ul>
</div>
