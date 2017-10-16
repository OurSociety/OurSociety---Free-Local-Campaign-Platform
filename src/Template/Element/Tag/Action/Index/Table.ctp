<?php

use OurSociety\View\Tag\Action\Index\Paginator;
use OurSociety\View\Tag\Action\Index\TableBody;
use OurSociety\View\Tag\Action\Index\TableHead;

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Tag\Action\Index\Table $tag
 */

$fieldList = $tag->getFieldList();
?>

<h3><?= $tag->getHeading() ?></h3>
<table cellpadding="0" cellspacing="0">
    <?= $this->Tag->render(new TableHead($tag)) ?>
    <?= $this->Tag->render(new TableBody($tag)) ?>
</table>
<?= $this->Tag->render(new Paginator()) ?>
