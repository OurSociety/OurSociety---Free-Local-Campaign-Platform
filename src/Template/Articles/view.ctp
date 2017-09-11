<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\Article $article The currently viewed article.
 * @var \OurSociety\Model\Entity\User $politician The currently viewed politician.
 */

$this->extend('/Common/Articles/view');

$this->start('breadcrumbs');
?>
<ol class="breadcrumb">
    <li><?= $this->Html->dashboardLink() ?></li>
    <li><?= $this->Html->link('Politicians', ['_name' => 'politicians']) ?></li>
    <li><?= $this->Html->politicianLink($politician) ?></li>
    <li><?= $this->Html->politicianLink($politician, __('Articles'), ['#' => 'articles']) ?></li>
    <li><?= $article->name ?></li>
</ol>
<?php
$this->end();
?>
