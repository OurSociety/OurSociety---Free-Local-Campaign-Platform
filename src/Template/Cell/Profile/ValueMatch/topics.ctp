<?php
/**
 * @var string $name The name of the list (similarities or differences).
 * @var \Cake\ORM\ResultSet|\OurSociety\Model\Entity\Category[] $topics List of categories with match percentage.
 */
?>
<h4><?= $name ?></h4>
<ol class="list-unstyled">
    <?php foreach ($topics as $topic): ?>
        <li>
            <b class="topic topic-<?= $topic->slug ?>">[ICON]</b>
            <?= __('{percentage}% {topic_name}', ['percentage' => $topic->match, 'topic_name' => $topic->name]) ?>
        </li>
    <?php endforeach ?>
</ol>
