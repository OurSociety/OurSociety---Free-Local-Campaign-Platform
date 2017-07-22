<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $politician The currently viewed politician.
 * @var \OurSociety\Model\Entity\PoliticianArticle $article The currently viewed article.
 * @var \OurSociety\Model\Entity\User $currentUser The currently authenticated user.
 */
?>
<ol class="breadcrumb">
    <li><?= $this->Html->dashboardLink() ?></li>
    <li><?= $this->Html->link('Politicians', ['_name' => 'citizen:politicians']) ?></li>
    <li><?= $this->Html->politicianLink($politician) ?></li>
    <li><?= $this->Html->politicianLink($politician, __('Articles'), ['#' => 'articles']) ?></li>
    <li><?= $article->name ?></li>
</ol>

<h2>
    <?= $article->name ?>
    <?php if ($currentUser->isPolitician()): ?>
        <?= $this->Html->link(
            __('Edit article'),
            ['_name' => 'politician:article:edit', 'article' => $article->slug],
            ['class' => 'btn btn-default']
        ) ?>
    <?php endif ?>
</h2>

<hr>

<?= $article->body ?>
