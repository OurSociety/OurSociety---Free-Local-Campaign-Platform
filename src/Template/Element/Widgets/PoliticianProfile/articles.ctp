<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\User $politician The politician.
 */
?>

<?php if (count($politician->articles) === 0): ?>
    <p>
        <?= __("This representative hasn't posted any articles.") ?>
    </p>
<?php else: ?>
    <?php foreach ($politician->articles as $article): ?>
        <div class="media">
            <div class="media-body">
                <h4 class="media-heading">
                    <?php if ($this->request->getParam('prefix') === 'politician'): ?>
                        <?= $this->Html->link($article->name, [
                            'prefix' => 'politician/profile',
                            'controller' => 'Articles',
                            'action' => 'view',
                            $article->id,
                        ]) ?>
                    <?php else: ?>
                        <?= $this->Html->link($article->name, [
                            '_name' => 'politician:article',
                            'politician' => $politician->slug,
                            'article' => $article->slug,
                        ]) ?>
                    <?php endif ?>
                    <span class="text-muted small">
                        <?= $article->published ? $article->published->toFormattedDateString() : __('Unpublished') ?>
                    </span>
                </h4>
                <p><?= $this->Text->truncate($article->body, 360, ['html' => true]) ?></p>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>
