<?php
/**
 * @var \OurSociety\View\AppView $this View class.
 * @var \OurSociety\Model\Entity\Event $event The event.
 */
?>

<small class="text-muted">
    <?= $this->Time->niceLong($event->start) ?>
    &ndash;
</small>

<?= $event->name ?> @ <?= $event->location ?>
