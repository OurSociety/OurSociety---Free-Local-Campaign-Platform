<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Article $article
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Article'), ['action' => 'edit', $article->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Article'), ['action' => 'delete', $article->id], ['confirm' => __('Are you sure you want to delete # {0}?', $article->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Articles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Article'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Aspects'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Aspect'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Article Types'), ['controller' => 'ArticleTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Article Type'), ['controller' => 'ArticleTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Electoral Districts'), ['controller' => 'ElectoralDistricts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Electoral District'), ['controller' => 'ElectoralDistricts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Politicians'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Politician'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="articles view large-9 medium-8 columns content">
    <h3><?= h($article->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($article->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Politician') ?></th>
            <td><?= $article->has('politician') ? $this->Html->link($article->politician->name, ['controller' => 'Users', 'action' => 'view', $article->politician->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Slug') ?></th>
            <td><?= h($article->slug) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($article->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Aspect') ?></th>
            <td><?= $article->has('aspect') ? $this->Html->link($article->aspect->name, ['controller' => 'Categories', 'action' => 'view', $article->aspect->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Article Type') ?></th>
            <td><?= $article->has('article_type') ? $this->Html->link($article->article_type->name, ['controller' => 'ArticleTypes', 'action' => 'view', $article->article_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Electoral District') ?></th>
            <td><?= $article->has('electoral_district') ? $this->Html->link($article->electoral_district->label, ['controller' => 'ElectoralDistricts', 'action' => 'view', $article->electoral_district->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Version') ?></th>
            <td><?= $this->Number->format($article->version) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Approved') ?></th>
            <td><?= h($article->approved) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Published') ?></th>
            <td><?= h($article->published) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($article->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($article->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Body') ?></h4>
        <?= $this->Text->autoParagraph(h($article->body)); ?>
    </div>
</div>
