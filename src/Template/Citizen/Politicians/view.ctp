<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $politician The currently viewed politician.
 */
?>

<?php $this->extend('/Common/Politicians/view') ?>

<?php $this->start('breadcrumbs'); ?>
<ol class="breadcrumb">
    <li><?= $this->Html->dashboardLink() ?></li>
    <li><?= $this->Html->link('Politicians', ['_name' => 'citizen:politicians']) ?></li>
    <li><?= $politician->name ?></li>
</ol>
<?php $this->end() ?>
