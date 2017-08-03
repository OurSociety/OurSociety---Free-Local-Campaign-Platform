<?php
/**
 * @var \OurSociety\View\AppView $this
 */
?>

<div class="card-footer text-muted">
    <div class="row">
        <!--
        <div class="col">
            <?= $this->element('index/download_formats', compact('indexFormats')); ?>
        </div>
        -->
        <div class="col">
            <?php if ($this->Paginator->hasPage(2)): ?>
                <?= $this->Paginator->numbers([
                    'prev' => true,
                    'next' => true,
                    'before' => '<nav aria-label="Page navigation"><ul class="pagination">',
                    'after' => '</ul></nav>',
                ]) ?>
            <?php endif ?>
        </div>
        <div class="col text-right">
            <?= $this->Paginator->counter('Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total.'); ?>
        </div>
    </div>
</div>
