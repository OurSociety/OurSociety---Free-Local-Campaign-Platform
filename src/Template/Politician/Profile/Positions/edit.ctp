<?php

use OurSociety\View\Component\Layout\Icon;

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $identity
 * @var \OurSociety\Model\Entity\Award $record
 */

$this->Breadcrumbs->add(__('My Dashboard'), $identity->getDashboardRoute());
$this->Breadcrumbs->add(__('My Profile'), $identity->getProfileRoute());
$this->Breadcrumbs->add(__('My Positions'), ['_name' => 'politician:profile:qualifications']);
$this->Breadcrumbs->add($record->name);
?>

<div class="card">

    <h4 class="card-header">
        <?= $this->Component->render(new Icon($record->getIcon())) ?>
        <?= __('{action} Position', ['action' => $record->isNew() ? 'Create' : 'Edit']) ?>
        <small class="text-muted"><?= $record->name ?></small>
    </h4>

    <div class="card-body">

        <?= $this->Form->create($record, [
            'layout' => ['type' => 'grid'],
        ]) ?>
        <?= $this->Form->controls([
            'name' => [
                'label' => 'Position Title',
            ],
            'company' => [
                'label' => 'Company Name',
            ],
            'started' => [
                'label' => 'Date Started',
                'type' => 'month',
                'min' => $record->getMinDate(),
                'max' => $record->getMaxDate(),
            ],
            'ended' => [
                'label' => 'Date Ended',
                'type' => 'month',
                'min' => $record->getMinDate(),
                'max' => $record->getMaxDate(),
            ],
        ], ['legend' => false]) ?>
        <?= $this->Form->submit() ?>
        <?= $this->Form->end() ?>

    </div>

</div>
