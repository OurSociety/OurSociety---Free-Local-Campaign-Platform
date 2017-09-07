<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\ElectoralDistrict $municipality The municipality.
 * @var \OurSociety\Model\Entity\PoliticianArticle[] $articles The articles.
 */


$articles = $articles ?? [];
$actualCount = count($articles);
$desiredCount = 4;

if ($actualCount < $desiredCount):
    $exampleArticles = \OurSociety\Model\Entity\PoliticianArticle::examples($desiredCount - $actualCount);
    $articles = array_merge($articles, $exampleArticles);
endif;
?>

<div class="float-right">
    <div class="btn-group">
        <?= $this->Html->link(
            __('Submit Your Own Idea'),
            ['_name' => 'municipality:article:new', 'municipality' => $municipality->slug],
            ['icon' => 'fire', 'class' => ['btn', 'btn-outline-dark']]
        ) ?>
        <?= $this->Html->link(
            __('View All'),
            ['_name' => 'municipality:articles', 'municipality' => $municipality->slug],
            ['icon' => 'list', 'class' => ['btn', 'btn-outline-dark']]
        ) ?>
    </div>
</div>

<!--
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
-->

<h2>
    <?= __('Trending Policies, Plans & Values') ?>
</h2>

<div class="card-deck pt-2">
    <?php foreach ($articles as $article): ?>
        <?= $article->renderCardElement($this) ?>
    <?php endforeach ?>
</div>
