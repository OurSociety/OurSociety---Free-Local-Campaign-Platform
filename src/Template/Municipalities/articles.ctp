<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \Cake\ORM\ResultSet|\OurSociety\Model\Entity\Article[] $articles The articles.
 * @var \OurSociety\Model\Entity\ElectoralDistrict $municipality The municipality.
 */
?>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <?= $this->Html->link(__('My Municipality'), ['_name' => 'municipality:default']) ?>
    </li>
    <li class="breadcrumb-item">
        <?= $this->Html->link($municipality->display_name, ['_name' => 'municipality', $municipality->slug]) ?>
    </li>
    <li class="breadcrumb-item active">
        <?= __('Policies, Plans & Values') ?>
    </li>
</ol>

<h1>
    <?= __('Policies, Plans & Values') ?>
</h1>

<p>Choose one of the articles below to start reading.</p>

<?php foreach ($articles as $article): ?>
    <?= $article->renderSummaryElement($this) ?>
<?php endforeach ?>
