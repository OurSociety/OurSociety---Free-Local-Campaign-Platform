<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Tag\Action\Index\TableCell $tag
 */

$value = $tag->printValue();
if ($tag->isDisplayField()) {
    $value = $this->Html->link($value, ['action' => 'view', $tag->getPrimaryKey()]);
}
?>

<?= $this->Html->tag($tag->getTagName(), $value) ?>
