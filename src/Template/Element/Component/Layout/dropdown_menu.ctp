<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Layout\DropdownMenu $dropdownMenu
 */
?>
<a class="nav-link dropdown-toggle text-nowrap" href="#" id="<?= $dropdownMenu->getElementId() ?>"
   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?= $dropdownMenu->getTitle() ?>
</a>
<div class="dropdown-menu" aria-labelledby="<?= $dropdownMenu->getElementId() ?>">
    <?php foreach ($dropdownMenu->getEntries() as $entry): ?>
        <?= $this->Component->render($entry) ?>
    <?php endforeach ?>
</div>
