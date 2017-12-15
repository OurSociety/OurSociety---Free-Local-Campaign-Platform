<?php

use OurSociety\View\Component\Layout\Icon;

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $identity
 * @var \OurSociety\Model\Entity\Award $record
 */

$this->Breadcrumbs->add(__('My Dashboard'), $identity->getDashboardRoute());
$this->Breadcrumbs->add(__('My Profile'), $identity->getProfileRoute());
$this->Breadcrumbs->add(__('My Awards'), ['_name' => 'politician:profile:awards']);
$this->Breadcrumbs->add($record->name);
?>

<div class="card">

    <h4 class="card-header">
        <?= $this->Component->render(new Icon($record->getIcon())) ?>
        <?= __('Edit Award') ?>
        <small class="text-muted"><?= $record->name ?></small>
    </h4>

    <div class="card-body">

        <?= $this->Form->create($record, [
            'layout' => ['type' => 'grid'],
        ]) ?>
        <?= $this->Form->controls([
            'name' => [
                'label' => 'Award Title',
            ],
            'description' => [
                'label' => 'Description of Award',
                'type' => 'editor',
            ],
            'obtained' => [
                'label' => 'Date Obtained',
                'type' => 'month',
                'min' => $record->getMinDate(),
                'max' => $record->getMaxDate(),
            ],
        ], ['legend' => false]) ?>
        <?= $this->Form->submit() ?>
        <?= $this->Form->end() ?>

    </div>

</div>
