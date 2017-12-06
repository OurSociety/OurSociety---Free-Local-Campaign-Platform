<?php
/**
 * @var \OurSociety\View\AppView $this
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Articles'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Aspects'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Aspect'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Article Types'), ['controller' => 'ArticleTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Article Type'), ['controller' => 'ArticleTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Electoral Districts'), ['controller' => 'ElectoralDistricts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Electoral District'), ['controller' => 'ElectoralDistricts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Representatives'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Representative'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="articles form large-9 medium-8 columns content">
    <?= $this->Form->create($article) ?>
    <fieldset>
        <legend><?= __('Add Article') ?></legend>
        <?php
        echo $this->Form->control('politician_id', ['options' => $politicians]);
        echo $this->Form->control('slug');
        echo $this->Form->control('name');
        echo $this->Form->control('body');
        echo $this->Form->control('version');
        echo $this->Form->control('aspect_id', ['options' => $aspects, 'empty' => true]);
        echo $this->Form->control('article_type_id', ['options' => $articleTypes, 'empty' => true]);
        echo $this->Form->control('electoral_district_id', ['options' => $electoralDistricts, 'empty' => true]);
        echo $this->Form->control('approved', ['empty' => true]);
        echo $this->Form->control('published', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
