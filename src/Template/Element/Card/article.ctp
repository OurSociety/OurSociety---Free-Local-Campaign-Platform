<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\Article $article The article.
 */
?>

<div class="card<?= $article->is_example ? ' example' : null ?>">

    <?= $article->renderAspectIcon($this, ['style' => 'opacity: .05', 'height' => '275']) ?>

    <div class="card-img-overlay text-center">
        <h5 class="card-title">
            <?= $article->renderMunicipalViewLink($this) ?>
        </h5>

        <h6 class="card-subtitle mb-2 text-muted">
            <?= $article->printArticleType() ?>
        </h6>

        <?= $article->printTruncatedBody() ?>

        <p class="card-text">
            <small class="text-muted">
                <?= __('{read_time} min read', ['read_time' => $article->read_time]) ?>
            </small>
        </p>
    </div>

</div>
