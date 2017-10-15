<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $politician
 * @var \OurSociety\Model\Entity\User $identity
 */

$this->Breadcrumbs->add(__('My Municipality'), ['_name' => 'municipality:default']);
$this->Breadcrumbs->add(__('Community Contributor'));
$this->Breadcrumbs->add($politician->name, $politician->getPublicProfileRoute());
$this->Breadcrumbs->add(__('Value Match'));
?>

<h2>
    <?= __('Value Match') ?>
</h2>

<hr>

<p>
    <?= __('Your values in comparison to politician {politician_name}.', ['politician_name' => $politician->name]) ?>
</p>

<?= $this->cell('Profile/ValueMatch', [$politician, $identity, 9999]) ?>
