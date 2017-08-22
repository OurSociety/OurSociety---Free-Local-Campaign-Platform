<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\PoliticianArticle $article The currently viewed article.
 * @var \OurSociety\Model\Entity\User $currentUser The currently authenticated user.
 */
?>
<?= $this->fetch('breadcrumbs') ?>

<div class="pull-right">
    <?= $this->fetch('actions') ?>
</div>

<h2>
    <?= $article->name ?>
</h2>

<hr>

<?= $article->body ?>
