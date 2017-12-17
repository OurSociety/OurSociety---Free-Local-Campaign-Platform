<?php

use OurSociety\Action\Admin\Users\ImpersonateUserAction;

/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\User $identity The identity.
 */

if ($identity === null) {
    return;
}

$isAdminImpersonatingUser = $this->request->getSession()->read(ImpersonateUserAction::SESSION_KEY_ADMIN) !== null;
?>

<a class="nav-link dropdown-toggle text-nowrap" href="#" id="userMenuToggle"
   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <div class="profile-picture-round mr-2">
        <?= $identity->renderProfilePicture($this) ?>
    </div>
    <?php /*
    <span class="d-none d-lg-inline">
        <?= $identity->name ?>
    </span>
    */ ?>
</a>
<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuToggle"
     style="min-width: 100%">
    <p class="dropdown-item mb-0"><?= $identity->name ?></p>
    <div class="dropdown-divider"></div>
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
        <?= $this->Html->link(__('Account'), ['_name' => 'users:profile'], ['class' => ['dropdown-item'], 'icon' => 'cog']) ?>
    <?php endif ?>
    <?= $this->Html->link(__('Plans'), ['_name' => 'plans'], ['class' => ['dropdown-item'], 'icon' => 'th-list']) ?>
    <?= $this->Html->link(__('Billing'), $identity->getAccountRoute(), ['class' => ['dropdown-item'], 'icon' => 'credit-card']) ?>
    <div class="dropdown-divider"></div>
    <?= $this->Html->link(__('Sign Out'), $identity->getLogoutRoute(), [
        'class' => ['dropdown-item'],
        'icon' => 'sign-out',
    ]) ?>
</div>
