<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var string $name The name of the list (similarities or differences).
 * @var \Cake\ORM\ResultSet|\OurSociety\Model\Entity\ValueMatch[] $topics List of categories with match percentage.
 */
?>
<h4><?= $name ?></h4>
<ol class="list-unstyled">
    <?php foreach ($topics as $topic): ?>
        <li class="topic-item">
            <?= $this->Html->icon($topic->category->slug, ['iconSet' => 'topic', 'height' => 75, 'width' => 75]) ?>
            <?= $topic->true_match_percentage . '%' ?>
            <?= __($topic->category->name) ?>
        </li>
    <?php endforeach ?>
</ol>
