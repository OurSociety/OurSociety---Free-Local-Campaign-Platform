<?php
/**
 * @var \OurSociety\View\AppView $this
 */

$this->extend('/Common/Questions/index');

$this->start('breadcrumbs');
?>
<ol class="breadcrumb">
    <li><?= $this->Html->dashboardLink() ?></li>
    <li><?= __('My Voice') ?></li>
</ol>
<?php
$this->end();

$this->assign('introduction', 'By answering the following {count} questions, we can let you know which politicians in your area agree with you.');
