<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\PoliticianArticle $article The currently viewed article.
 * @var \OurSociety\Model\Entity\User $currentUser The currently authenticated user.
 */
?>
<?= $this->fetch('breadcrumbs') ?>

<h2>
    <?= $article->name ?>
    <?php if ($currentUser->isPolitician()): ?>
        <?= $this->Html->link(
            __('Edit article'),
            ['prefix' => 'politician/profile', 'controller' => 'Articles', 'action' => 'edit', $article->id],
            ['class' => 'btn btn-default']
        ) ?>
    <?php endif ?>
</h2>

<hr>

<?= $article->body ?>
