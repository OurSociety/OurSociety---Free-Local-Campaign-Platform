<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Tag\Menu\DropdownItem $tag
 */

$title = $tag->getTitle();
$url = $tag->getUrl();
$options = $tag->getOptions($this->request);
?>

<?= $this->Html->link($title, $url, $options) ?>
