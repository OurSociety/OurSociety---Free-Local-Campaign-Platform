<?php

use OurSociety\ORM\TableRegistry;
use OurSociety\View\Component\Listing\Table;
use OurSociety\View\Component\Field\Field;
use OurSociety\View\Component\Field\FieldList;

/**
 * @var \OurSociety\View\AppView $this
 * @var \Cake\ORM\ResultSet|\OurSociety\Model\Entity\Article[] $articles
 */
?>

<?= $this->Component->render(new Table($articles, new FieldList([
    new Field(TableRegistry::get('Articles'), 'politician_id'),
    new Field(TableRegistry::get('Articles'), 'name', ['title' => 'Article Title']),
    new Field(TableRegistry::get('Articles'), 'approved'),
    new Field(TableRegistry::get('Articles'), 'published'),
]))) ?>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Article'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Aspects'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Aspect'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Article Types'), ['controller' => 'ArticleTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Article Type'), ['controller' => 'ArticleTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Electoral Districts'), ['controller' => 'ElectoralDistricts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Electoral District'), ['controller' => 'ElectoralDistricts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Politicians'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Politician'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
