<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var string $pluralHumanName The CrudView variable with the plural human name of the model class.
 * @var string $viewVar The CrudView variable with the name of the view variable containing the entity being viewed.
 * @var string $displayField The CrudView variable with the name of the model class display field.
 */
$prefix = $this->request->getParam('prefix');
?>
<ol class="breadcrumb">
    <li><?= $this->Html->link(ucfirst($prefix), ['_name' => sprintf('%s:dashboard', $prefix)]) ?></li>
    <li><?= $this->Html->link($pluralHumanName, ['action' => 'index']) ?></li>
    <li><?= ${$viewVar}->{$displayField} ?></li>
</ol>
