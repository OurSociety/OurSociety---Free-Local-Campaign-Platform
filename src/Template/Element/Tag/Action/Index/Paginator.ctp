<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Tag\Action\Index\Paginator $paginator
 */

?>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first() ?>
        <?= $this->Paginator->prev() ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next() ?>
        <?= $this->Paginator->last() ?>
    </ul>
    <p><?= $this->Paginator->counter() ?></p>
</div>
