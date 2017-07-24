<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var string $pluralHumanName The plural human name of the model class from Crud plugin.
 */
$prefix = $this->request->getParam('prefix');
?>
<ol class="breadcrumb">
    <li><?= $this->Html->dashboardLink() ?></li>
    <li><?= $pluralHumanName ?></li>
</ol>
