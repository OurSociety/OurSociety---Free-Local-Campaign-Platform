<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\PoliticianArticle[]|\Cake\Collection\CollectionInterface $politicianArticles
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Politician Article'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="politicianArticles index large-9 medium-8 columns content">
    <h3><?= __('Politician Articles') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('politician_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('slug') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('version') ?></th>
                <th scope="col"><?= $this->Paginator->sort('approved') ?></th>
                <th scope="col"><?= $this->Paginator->sort('published') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($politicianArticles as $politicianArticle): ?>
            <tr>
                <td><?= h($politicianArticle->id) ?></td>
                <td><?= h($politicianArticle->politician_id) ?></td>
                <td><?= h($politicianArticle->slug) ?></td>
                <td><?= h($politicianArticle->name) ?></td>
                <td><?= $this->Number->format($politicianArticle->version) ?></td>
                <td><?= h($politicianArticle->approved) ?></td>
                <td><?= h($politicianArticle->published) ?></td>
                <td><?= h($politicianArticle->created) ?></td>
                <td><?= h($politicianArticle->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $politicianArticle->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $politicianArticle->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $politicianArticle->id], ['confirm' => __('Are you sure you want to delete # {0}?', $politicianArticle->id)]) ?>
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
