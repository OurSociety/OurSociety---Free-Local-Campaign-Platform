<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\PoliticianPosition[]|\Cake\Collection\CollectionInterface $politicianPositions
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Politician Position'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="politicianPositions index large-9 medium-8 columns content">
    <h3><?= __('Politician Positions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('politician_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('company') ?></th>
                <th scope="col"><?= $this->Paginator->sort('started') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ended') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($politicianPositions as $politicianPosition): ?>
            <tr>
                <td><?= h($politicianPosition->id) ?></td>
                <td><?= h($politicianPosition->politician_id) ?></td>
                <td><?= h($politicianPosition->name) ?></td>
                <td><?= h($politicianPosition->company) ?></td>
                <td><?= h($politicianPosition->started) ?></td>
                <td><?= h($politicianPosition->ended) ?></td>
                <td><?= h($politicianPosition->created) ?></td>
                <td><?= h($politicianPosition->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $politicianPosition->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $politicianPosition->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $politicianPosition->id], ['confirm' => __('Are you sure you want to delete # {0}?', $politicianPosition->id)]) ?>
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
