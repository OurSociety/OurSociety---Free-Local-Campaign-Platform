<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\PoliticianPosition $politicianPosition
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Politician Positions'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="politicianPositions form large-9 medium-8 columns content">
    <?= $this->Form->create($politicianPosition) ?>
    <fieldset>
        <legend><?= __('Add Politician Position') ?></legend>
        <?php
            echo $this->Form->control('politician_id');
            echo $this->Form->control('name');
            echo $this->Form->control('company');
            echo $this->Form->control('started');
            echo $this->Form->control('ended', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
