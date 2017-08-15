<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var string $pluralHumanName The plural human name of the model class from Crud plugin.
 */
$prefix = $this->request->getParam('prefix');
$legend = collection($fields)->filter(function ($options) {
    return isset($options['help']);
})
?>
<ol class="breadcrumb">
    <li><?= $this->Html->dashboardLink() ?></li>
    <li><?= $pluralHumanName ?></li>
</ol>

<dl class="col-xs-3 pull-right">
    <?php foreach ($legend as $field => $options): ?>
        <dt><?= $field ?></dt>
        <dd><?= $options['help'] ?></dd>
    <?php endforeach ?>
</dl>
