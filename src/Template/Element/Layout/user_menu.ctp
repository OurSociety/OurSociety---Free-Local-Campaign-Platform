<?php

use OurSociety\Action\Admin\Users\ImpersonateUserAction;

/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\User $identity The identity.
 */

$isAdminImpersonatingUser = $this->request->getSession()->read(ImpersonateUserAction::SESSION_KEY_ADMIN) !== null;
?>

<a class="nav-link dropdown-toggle text-nowrap" href="#" id="userMenuToggle"
   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?= $identity->renderProfilePicture($this, [
        'class' => ['align-middle', 'bg-light', 'rounded-circle', 'mr-2'],
        'style' => 'height: 32px; width: 32px; border: 2px solid white',
    ]) ?>
    <span class="d-none d-lg-inline">
                    <?= $identity->name ?>
                </span>
</a>
<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuToggle"
     style="min-width: 100%">
    <?php if ($identity->isAdmin()): ?>
        <?= $this->Html->link(__('Admin'), ['_name' => 'admin:dashboard'], ['class' => ['dropdown-item'], 'icon' => 'lock']) ?>
        <div class="dropdown-divider"></div>
        <?= $this->Html->link(__('Tutorial'), ['_name' => 'users:onboarding'], ['class' => ['dropdown-item'], 'icon' => 'question-circle']) ?>
    <?php else: ?>
        <?php if ($isAdminImpersonatingUser): ?>
            <?= $this->Html->link(__('Admin'), ['_name' => 'admin:users:switch'], ['class' => ['dropdown-item'], 'icon' => 'sign-in']) ?>
            <div class="dropdown-divider"></div>
        <?php endif ?>
        <?= $this->Html->link(__('Tutorial'), ['_name' => 'users:onboarding'], ['class' => ['dropdown-item'], 'icon' => 'question-circle']) ?>
        <?= $this->Html->link(__('Profile'), $identity->getProfileRoute(), ['class' => ['dropdown-item'], 'icon' => 'user']) ?>
    <?php endif ?>
    <?= $this->Html->link(__('Plans'), ['_name' => 'plans'], ['class' => ['dropdown-item'], 'icon' => 'th-list']) ?>
    <?= $this->Html->link(__('Billing'), $identity->getAccountRoute(), ['class' => ['dropdown-item'], 'icon' => 'credit-card']) ?>
    <div class="dropdown-divider"></div>
    <?= $this->Html->link(__('Sign Out'), $identity->getLogoutRoute(), [
        'class' => ['dropdown-item'],
        'icon' => 'sign-out',
    ]) ?>
</div>
