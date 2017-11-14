<?php

use OurSociety\View\Component\Listing\TableBody;
use OurSociety\View\Component\Listing\TableHead;

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Listing\Table $table
 */
?>

<table class="table table-bordered table-striped table-hover mb-0">
    <?= $this->Component->render(new TableHead($table)) ?>
    <?= $this->Component->render(new TableBody($table)) ?>
</table>
