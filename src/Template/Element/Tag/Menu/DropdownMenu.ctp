<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Tag\Menu\DropdownMenu $tag
 */
?>
<a class="nav-link dropdown-toggle text-nowrap" href="#" id="dashboards-dropdown"
   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?= $tag->getTitle() ?>
</a>
<div class="dropdown-menu" aria-labelledby="dashboards-dropdown">
    <?php foreach ($tag->getEntries() as $entry): ?>
        <?= $this->Tag->render($entry) ?>
    <?php endforeach ?>
</div>
