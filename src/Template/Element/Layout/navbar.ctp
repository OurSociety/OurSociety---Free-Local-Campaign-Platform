<?php

use OurSociety\Model\Entity\ElectoralDistrict;
use OurSociety\Model\Entity\User;
use OurSociety\View\AppView;
use OurSociety\View\Component\Layout\NavLink;

/**
 * @var AppView $this The view.
 * @var User $identity The identity.
 */

if ($this->request->getParam('prefix') === 'admin'):
    return;
endif;

$callToActionLink = $this->Url->build([
    '_name' => 'users:register',
    '?' => [
        'redirect' => $this->Url->build(['_name' => 'citizen:questions']),
    ],
]);
?>

<header class="navbar navbar-expand navbar-dark flex-column flex-md-row os-navbar">
    <a href="<?= $this->Url->build(['_name' => 'root']) ?>" aria-label="OurSociety" class="navbar-brand">
        <?= $this->element('Layout/brand') ?>
    </a>

    <div class="navbar-nav-scroll">
        <ul class="navbar-nav os-navbar-nav flex-wrap">
            <?php if ($identity !== null): ?>
                <li class="nav-item text-nowrap">
                    <?= $this->Component->render(new NavLink(__('My Dashboard'), $identity->getDashboardRoute($identity->isAdmin() ? User::ROLE_CITIZEN : null))) ?>
                </li>
                <li class="nav-item text-nowrap">
                    <?= $this->Component->render(new NavLink(__('My Municipality'), ['_name' => 'municipality:default'])) ?>
                </li>
            <?php else: ?>
                <li class="nav-item text-nowrap">
                    <?= $this->Component->render(new NavLink(__('Home'), ['_name' => 'home'])) ?>
                </li>
            <?php endif ?>
            <li class="nav-item text-nowrap">
                <?= $this->Component->render(new NavLink(__('Municipalities'), (new ElectoralDistrict)->getBrowseRoute())) ?>
            </li>
            <li class="nav-item text-nowrap">
                <?= $this->Component->render(new NavLink(__('Representatives'), ['_name' => 'politicians'])) ?>
            </li>
        </ul>
    </div>

    <div class="flex-row ml-md-auto d-none d-md-flex">
        <?= $this->element('Search/bar') ?>

        <ul class="navbar-nav os-navbar-nav ml-3">
            <?php if ($identity !== null): ?>
                <li class="nav-item dropdown" id="notificationMenu">
                    <?= $this->element('Layout/notification_menu') ?>
                </li>
                <li class="nav-item dropdown" id="userMenu">
                    <?= $this->element('Layout/user_menu') ?>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Sign In'), ['_name' => 'users:login'], ['class' => ['btn', 'btn-os-yellow', 'd-none', 'd-lg-inline-block', 'mb-3', 'mb-md-0', 'ml-md-3'],]) ?>
                </li>
            <?php endif ?>
        </ul>
    </div>

</header>
