<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\PoliticianArticle[] $articles The articles.
 */

$isExample = count($articles) === 0;
if ($isExample) {
    $articles = \OurSociety\Model\Entity\PoliticianArticle::examples(5);
}
?>

<div class="float-right">
    <div class="btn-group">
        <div class="btn btn-outline-dark disabled">
            <i class="fa fa-fw fa-fire"></i>
            <?= __('Hot') ?>
        </div>
        <div class="btn btn-outline-dark disabled">
            <i class="fa fa-fw fa-asterisk"></i>
            <?= __('New') ?>
        </div>
        <div class="btn btn-outline-dark disabled">
            <i class="fa fa-fw fa-line-chart"></i>
            <?= __('Top') ?>
        </div>
    </div>
</div>

<h2>
    <?= __('Trending Policies, Plans & Values') ?>
</h2>

<div class="card-deck pt-2<?= $isExample ? ' example' : null ?>">
    <?php foreach ($articles as $article): ?>
        <?= $article->renderCardElement($this) ?>
    <?php endforeach ?>
</div>
