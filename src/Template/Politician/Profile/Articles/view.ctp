<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\Article $article The currently viewed article.
 */

$this->extend('/Common/Articles/view');

$this->start('breadcrumbs');
?>
<ol class="breadcrumb">
    <li><?= $this->Html->dashboardLink() ?></li>
    <li><?= $this->Html->link(__('Profile'), ['_name' => 'politician:profile']) ?></li>
    <li><?= $article->name ?></li>
</ol>
<?php
$this->end();

$this->start('actions');
?>
    <?= $article->renderPoliticianEditButton($this) ?>
<?php
$this->end();
