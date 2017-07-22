<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\PoliticianAward $politicianAward
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Politician Award'), ['action' => 'edit', $politicianAward->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Politician Award'), ['action' => 'delete', $politicianAward->id], ['confirm' => __('Are you sure you want to delete # {0}?', $politicianAward->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Politician Awards'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Politician Award'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="politicianAwards view large-9 medium-8 columns content">
    <h3><?= h($politicianAward->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($politicianAward->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Politician Id') ?></th>
            <td><?= h($politicianAward->politician_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($politicianAward->name) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($politicianAward->description)); ?>
    </div>
</div>
