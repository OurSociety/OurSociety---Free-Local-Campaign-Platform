<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $identity The identity.
 * @var string $pluralHumanName The plural human name of the model class from Crud plugin.
 */
$prefix = $this->request->getParam('prefix');
$legend = collection($fields)->filter(function ($options) {
    return isset($options['help']);
});

$this->Breadcrumbs->add(__('My Dashboard'), $identity->getDashboardRoute());
$this->Breadcrumbs->add(__('My Profile'), $identity->getProfileRoute());
$this->Breadcrumbs->add($pluralHumanName);
?>

<dl class="col-xs-3 pull-right">
    <?php foreach ($legend as $field => $options): ?>
        <dt><?= $field ?></dt>
        <dd><?= $options['help'] ?></dd>
    <?php endforeach ?>
</dl>
