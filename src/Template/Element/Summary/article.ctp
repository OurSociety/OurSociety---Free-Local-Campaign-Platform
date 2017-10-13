<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Article $article
 */
?>

<div class="media">
    <div class="media-body">
        <h3>
            <?= $article->renderMunicipalViewLink($this) ?>
        </h3>

        <h6>
            <span class="text-muted">
                <?= $article->printArticleType() ?> &ndash; <?= $this->Time->niceLong($article->published) ?>
            </span>
        </h6>

        <p>
            <?= $article->printTruncatedBody(300) ?>
        </p>
    </div>

    <?= $article->renderAspectIcon($this, ['class' => ['d-flex', 'ml-3']]) ?>
</div>
