<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\User $currentUser
 * @var \OurSociety\Model\Entity\Event $event The event.
 */

$this->set('title', sprintf('%s (%s)', $event->name, $event->location));

$this->Breadcrumbs->add(__('Municipalities'), $event->electoral_district->getBrowseRoute());
$this->Breadcrumbs->add($event->electoral_district->name, $event->electoral_district->getViewRoute());
$this->Breadcrumbs->add(__('Upcoming Events'), $event->electoral_district->getEventsIndexRoute());
$this->Breadcrumbs->add($event->name);
?>

<div class="row">
    <div class="col">
        <h1>
            <?= $event->name ?>
            <small class="text-muted">
                @ <?= $event->location ?>
            </small>
        </h1>
    </div>
    <?php if ($currentUser && $currentUser->canEditMunicipality($event->electoral_district)): ?>
        <div class="col col-auto">
            <?= $this->Html->link(__('Edit Event'), $event->getEditRoute(), [
                'class' => ['btn btn-outline-dark'],
                'icon' => 'pencil',
            ]) ?>
        </div>
    <?php endif ?>
</div>

<h3 class="text-muted">
    <?= $this->Time->niceLong($event->start) ?>
</h3>

<?= $event->description ?>
