<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var string $name The name of the list (similarities or differences).
 * @var \Cake\ORM\ResultSet|\OurSociety\Model\Entity\Category[] $topics List of categories with match percentage.
 */
?>
<h4><?= $name ?></h4>
<ol class="list-unstyled text-left">
    <?php foreach ($topics as $topic): ?>
        <li class="topic-item<?= !isset($topic->value_match) ? ' text-muted' : '' ?>">
            <?= $this->Html->icon($topic->slug, ['iconSet' => 'topic', 'height' => 75, 'width' => 75]) ?>
            <?= isset($topic->value_match) ? $topic->value_match->true_match_percentage . '%' : 'N/A'?>
            <?= __($topic->name) ?>
        </li>
    <?php endforeach ?>
</ol>
