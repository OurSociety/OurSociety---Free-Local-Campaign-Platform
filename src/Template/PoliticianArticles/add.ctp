<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\PoliticianArticle $politicianArticle
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Politician Articles'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="politicianArticles form large-9 medium-8 columns content">
    <?= $this->Form->create($politicianArticle) ?>
    <fieldset>
        <legend><?= __('Add Politician Article') ?></legend>
        <?php
            echo $this->Form->control('politician_id');
            echo $this->Form->control('slug');
            echo $this->Form->control('name');
            echo $this->Form->control('body');
            echo $this->Form->control('version');
            echo $this->Form->control('approved', ['empty' => true]);
            echo $this->Form->control('published', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
