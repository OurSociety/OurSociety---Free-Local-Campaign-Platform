<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\PoliticianArticle $article The article.
 */
?>

<div class="card<?= $article->is_example ? ' example' : null ?>">

    <?= $this->Html->icon(
        $article->aspect ? $article->aspect->slug : 'government-operation-politics',
        ['iconSet' => 'topic', 'style' => 'opacity: .05', 'height' => '275']
    ) ?>

    <div class="card-img-overlay text-center">
        <h5 class="card-title">
            <?= $article->renderMunicipalViewLink($this) ?>
        </h5>

        <h6 class="card-subtitle mb-2 text-muted">
            <?= $article->article_type
                ? $article->article_type->name
                : 'Miscellaneous' ?>
        </h6>

        <?= \Cake\Utility\Text::truncateByWidth($article->body, 100, ['html' => true]) ?>

        <p class="card-text">
            <small class="text-muted">
                <?= __('{read_time} min read', ['read_time' => $article->read_time]) ?>
            </small>
        </p>
    </div>

</div>
