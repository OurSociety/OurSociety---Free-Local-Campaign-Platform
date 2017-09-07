<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\Event $event The event.
 */
?>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><?= $this->Html->link(__('My Municipality'), ['_name' => 'municipality:default']) ?></li>
    <li class="breadcrumb-item"><?= $this->Html->link($event->electoral_district->name, ['_name' => 'municipality', 'municipality' => $event->electoral_district->slug]) ?></li>
    <li class="breadcrumb-item"><?= $this->Html->link(__('Events'), ['_name' => 'municipality:events', 'municipality' => $event->electoral_district->slug]) ?></li>
    <li class="breadcrumb-item active"><?= $event->name ?></li>
</ol>

<h1>
    <?= $event->name ?>
    <small class="text-muted">
        @ <?= $event->location ?>
    </small>
</h1>

<h3 class="text-muted">
    <?= $this->Time->niceLong($event->start) ?>
</h3>

<?= $event->description ?>
