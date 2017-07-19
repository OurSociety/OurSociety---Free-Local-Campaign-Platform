<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\PoliticianAward $politicianAward
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $politicianAward->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $politicianAward->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Politician Awards'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="politicianAwards form large-9 medium-8 columns content">
    <?= $this->Form->create($politicianAward) ?>
    <fieldset>
        <legend><?= __('Edit Politician Award') ?></legend>
        <?php
            echo $this->Form->control('politician_id');
            echo $this->Form->control('name');
            echo $this->Form->control('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
