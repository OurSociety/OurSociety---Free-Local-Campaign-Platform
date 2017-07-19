<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\PoliticianQualification[]|\Cake\Collection\CollectionInterface $politicianQualifications
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Politician Qualification'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="politicianQualifications index large-9 medium-8 columns content">
    <h3><?= __('Politician Qualifications') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('politician_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('institution') ?></th>
                <th scope="col"><?= $this->Paginator->sort('started') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ended') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($politicianQualifications as $politicianQualification): ?>
            <tr>
                <td><?= h($politicianQualification->id) ?></td>
                <td><?= h($politicianQualification->politician_id) ?></td>
                <td><?= h($politicianQualification->name) ?></td>
                <td><?= h($politicianQualification->institution) ?></td>
                <td><?= h($politicianQualification->started) ?></td>
                <td><?= h($politicianQualification->ended) ?></td>
                <td><?= h($politicianQualification->created) ?></td>
                <td><?= h($politicianQualification->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $politicianQualification->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $politicianQualification->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $politicianQualification->id], ['confirm' => __('Are you sure you want to delete # {0}?', $politicianQualification->id)]) ?>
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
