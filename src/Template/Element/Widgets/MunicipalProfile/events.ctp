<?php
/**
 * @var \OurSociety\View\AppView $this View class.
 * @var \OurSociety\Model\Entity\Event[] $events The events.
 */

$isExample = count($events) === 0;
if ($isExample):
    $events = \OurSociety\Model\Entity\Event::examples(5);
endif;
?>

<div<?= $isExample ? ' class="example"' : null ?>>
    <?= $this->Html->link('View All', '#', ['class' => ['btn', 'btn-outline-dark', 'float-right']]) ?>

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
