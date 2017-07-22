<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\PoliticianQualification $politicianQualification
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $politicianQualification->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $politicianQualification->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Politician Qualifications'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="politicianQualifications form large-9 medium-8 columns content">
    <?= $this->Form->create($politicianQualification) ?>
    <fieldset>
        <legend><?= __('Edit Politician Qualification') ?></legend>
        <?php
            echo $this->Form->control('politician_id');
            echo $this->Form->control('name');
            echo $this->Form->control('institution');
            echo $this->Form->control('started');
            echo $this->Form->control('ended', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
