<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\Article $article The currently viewed article.
 * @var \OurSociety\Model\Entity\User $identity The currently authenticated user.
 */
?>
<?= $this->fetch('breadcrumbs') ?>

<div class="pull-right">
    <?= $this->fetch('actions') ?>
</div>

<h2>
    <?= $article->name ?>
</h2>

Posted by <?= $article->renderProfileLink($this) ?>

<hr>

<?= $article->body ?>
