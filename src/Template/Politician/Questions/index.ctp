<?php
/**
 * @var \OurSociety\View\AppView $this
 */
$this->extend('/Common/Questions/index');

$this->start('breadcrumbs');
?>
<ol class="breadcrumb">
    <li><?= $this->Html->dashboardLink() ?></li>
    <li><?= $this->Html->link(__('Profile'), ['_name' => 'politician:profile']) ?></li>
    <li><?= __('My Voice') ?></li>
</ol>
<?php
$this->end();

$this->start('actions');
echo $this->Html->link(__('View Profile'), ['_name' => 'politician:profile'], ['class' => ['btn btn-default pull-right']]);
$this->end();

$this->assign('introduction', 'By answering the following {count} questions, we can let citizens in your area know if they agree with you.');
