<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $identity
 * @var \OurSociety\Model\Entity\ElectoralDistrict $record
 * @var \OurSociety\Model\Entity\Question $question
 */

$this->Breadcrumbs->add(__('Municipalities'), $record->getBrowseRoute());

$this->Breadcrumbs->add($record->name, $record->getMunicipalityRoute());
$this->Breadcrumbs->add($record->name);
?>

<div class="card">
    <div class="card-header">
        <h4 class="mb-0">
            <?= $this->Html->icon('map', ['class' => ['fa-fw']]) ?>
            <?= __('Edit Town Information') ?>
        </h4>
    </div>
    <div class="card-body">
        <?= $this->Form->create($record) ?>
        <?= $this->Form->control('description', ['label' => false, 'placeholder' => __('Town Information')]) ?>
        <?= $this->Form->button(__('Update Town Information'), ['class' => ['btn-lg', 'btn-secondary', 'btn-block']]) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
