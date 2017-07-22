<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\PoliticianAward[]|\Cake\Collection\CollectionInterface $politicianAwards
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Politician Award'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="politicianAwards index large-9 medium-8 columns content">
    <h3><?= __('Politician Awards') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('politician_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($politicianAwards as $politicianAward): ?>
            <tr>
                <td><?= h($politicianAward->id) ?></td>
                <td><?= h($politicianAward->politician_id) ?></td>
                <td><?= h($politicianAward->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $politicianAward->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $politicianAward->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $politicianAward->id], ['confirm' => __('Are you sure you want to delete # {0}?', $politicianAward->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
