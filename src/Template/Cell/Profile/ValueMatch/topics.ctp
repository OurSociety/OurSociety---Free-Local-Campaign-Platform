<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var string $name The name of the list (similarities or differences).
 * @var \Cake\ORM\ResultSet|\OurSociety\Model\Entity\Category[] $topics List of categories with match percentage.
 */
?>
<h4><?= $name ?></h4>
<ol class="list-unstyled">
    <?php foreach ($topics as $topic): ?>
        <li class="topic-item">
            <?= $this->Html->icon($topic->slug, ['iconSet' => 'topic', 'height' => 75, 'width' => 75]) ?>
            <?= __($topic->name) ?>
            <?=''// __('{percentage}% {topic_name}', ['percentage' => $topic->match, 'topic_name' => $topic->name]) ?>
        </li>
    <?php endforeach ?>
</ol>
