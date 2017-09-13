<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\ElectoralDistrict $municipality The municipality.
 * @var \OurSociety\Model\Entity\Article[] $articles The articles.
 */

$articles = $articles ?? [];
$actualCount = count($articles);
$desiredCount = 4;

if ($actualCount < $desiredCount):
    $exampleArticles = \OurSociety\Model\Entity\Article::examples($desiredCount - $actualCount);
    $articles = array_merge($articles, $exampleArticles);
endif;
?>

<div class="card-deck pt-2">
    <?php foreach ($articles as $article): ?>
        <?= $article->renderCardElement($this) ?>
    <?php endforeach ?>
</div>
