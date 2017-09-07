<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\PoliticianArticle $article
 */
?>

<div class="media">
    <div class="media-body">
        <h3>
            <?= $article->renderMunicipalViewLink($this) ?>
        </h3>

        <h6>
            <span class="text-muted">
                <?= $article->article_type
                    ? $article->article_type->name
                    : 'Miscellaneous' ?>
                &ndash;
                <?= $this->Time->niceLong($article->published) ?>
            </span>
        </h6>

        <?= \Cake\Utility\Text::truncateByWidth($article->body, 300, ['html' => true]) ?>
    </div>

    <?= $article->aspect
        ? $this->Html->icon($article->aspect->slug, ['class' => ['d-flex', 'ml-3'], 'iconSet' => 'topic'])
        : null ?>
</div>
