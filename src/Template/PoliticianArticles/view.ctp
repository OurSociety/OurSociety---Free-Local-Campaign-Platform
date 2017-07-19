<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\PoliticianArticle $politicianArticle
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Politician Article'), ['action' => 'edit', $politicianArticle->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Politician Article'), ['action' => 'delete', $politicianArticle->id], ['confirm' => __('Are you sure you want to delete # {0}?', $politicianArticle->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Politician Articles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Politician Article'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="politicianArticles view large-9 medium-8 columns content">
    <h3><?= h($politicianArticle->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($politicianArticle->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Politician Id') ?></th>
            <td><?= h($politicianArticle->politician_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Slug') ?></th>
            <td><?= h($politicianArticle->slug) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($politicianArticle->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Version') ?></th>
            <td><?= $this->Number->format($politicianArticle->version) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Approved') ?></th>
            <td><?= h($politicianArticle->approved) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Published') ?></th>
            <td><?= h($politicianArticle->published) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($politicianArticle->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($politicianArticle->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Body') ?></h4>
        <?= $this->Text->autoParagraph(h($politicianArticle->body)); ?>
    </div>
</div>
