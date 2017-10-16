<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\User $currentUser The identity.
 */
?>

<ul class="navbar-nav os-navbar-nav ml-3">

    <?php if ($currentUser !== null): ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-nowrap" href="#" id="navbarDropdownMenuLink"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= $currentUser->renderProfilePicture($this, [
                    'class' => ['align-middle', 'bg-light', 'rounded-circle', 'mr-2'],
                    'style' => 'height: 32px; width: 32px; border: 2px solid white',
                ]) ?>
                <span class="d-none d-lg-inline">
                    <?= $currentUser->name ?>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink"
                 style="min-width: 100%">
                <?php if ($currentUser->isAdmin()): ?>
                    <?= $this->Html->link(__('Admin'), ['_name' => 'admin:dashboard'], ['class' => ['dropdown-item'], 'icon' => 'lock']) ?>
                    <div class="dropdown-divider"></div>
                <?php else: ?>
                    <?php if ($this->request->getSession()->read('Auth.Admin') !== null): ?>
                        <?= $this->Html->link(__('Admin'), ['_name' => 'admin:users:switch'], ['class' => ['dropdown-item'], 'icon' => 'sign-in']) ?>
                        <div class="dropdown-divider"></div>
                    <?php endif ?>
                    <?= $this->Html->link(__('Profile'), $currentUser->getProfileRoute(), ['class' => ['dropdown-item'], 'icon' => 'user']) ?>
                <?php endif ?>
                <?= $this->Html->link(__('Plans'), ['_name' => 'plans'], ['class' => ['dropdown-item'], 'icon' => 'th-list']) ?>
                <?= $this->Html->link(__('Billing'), $currentUser->getAccountRoute(), ['class' => ['dropdown-item'], 'icon' => 'credit-card']) ?>
                <div class="dropdown-divider"></div>
                <?= $this->Html->link(__('Sign Out'), $currentUser->getLogoutRoute(), [
                    'class' => ['dropdown-item'],
                    'icon' => 'sign-out',
                ]) ?>
            </div>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Sign In'), ['_name' => 'users:login'], [
                'class' => ['btn', 'btn-os-yellow', 'd-none', 'd-lg-inline-block', 'mb-3', 'mb-md-0', 'ml-md-3'],
            ]) ?>
        </li>
    <?php endif ?>
</ul>
