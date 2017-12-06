<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $identity The identity.
 * @var string $pluralHumanName The CrudView variable with the plural human name of the model class.
 * @var string $viewVar The CrudView variable with the name of the view variable containing the entity being viewed.
 * @var string $displayField The CrudView variable with the name of the model class display field.
 */
$prefix = $this->request->getParam('prefix');

$this->Breadcrumbs->add(__('My Dashboard'), $identity->getDashboardRoute());
try {
    $this->Breadcrumbs->add($pluralHumanName, ['action' => 'index']);
} catch (\Cake\Routing\Exception\MissingRouteException $exception) {
}
$this->Breadcrumbs->add(${$viewVar}->{$displayField});
