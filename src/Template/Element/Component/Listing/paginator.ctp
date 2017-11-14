<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Listing\Paginator $paginator
 */
?>

<div class="row align-items-center">

    <div class="col">
        <p class="small text-muted mb-0"><?= $this->Paginator->counter() ?></p>
    </div>

    <div class="col-auto">
        <ul class="pagination pagination-sm mb-0">
            <?= $this->Paginator->first() ?>
            <?= $this->Paginator->prev() ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next() ?>
            <?= $this->Paginator->last() ?>
        </ul>
    </div>

</div>
