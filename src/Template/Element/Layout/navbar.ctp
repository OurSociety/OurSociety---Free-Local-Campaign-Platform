<?php

use OurSociety\Model\Entity\{
    ElectoralDistrict, User
};
use OurSociety\View\AppView;
use OurSociety\View\Component\Layout\{
    DropdownItem, DropdownMenu, NavLink
};

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

    <ul class="navbar-nav" style="position: absolute; right: 8px; top: 8px">
        <li class="nav-item text-nowrap d-md-none">
            <?= $this->element('Layout/user_menu') ?>
        </li>
    </ul>

    <div class="navbar-nav-scroll">
        <ul class="navbar-nav os-navbar-nav flex-wrap">
            <?php if ($identity !== null): ?>
                <li class="nav-item dropdown-md text-nowrap">
                    <?= $this->Component->render(new DropdownMenu('Dashboard', [
                        new DropdownItem(
                            __('My Dashboard'),
                            $identity->getDashboardRoute($identity->isAdmin() ? User::ROLE_CITIZEN : null),
                            ['icon' => 'dashboard']
                        ),
                        new DropdownItem(
                            __('My Municipality'),
                            ['_name' => 'municipality:default'],
                            ['icon' => 'street-view']
                        ),
                    ])) ?>
                </li>
            <?php else: ?>
                <li class="nav-item text-nowrap">
                    <?= $this->Component->render(new NavLink(__('Home'), ['_name' => 'home'])) ?>
                </li>
            <?php endif ?>
            <li class="nav-item dropdown-md text-nowrap">
                <?= $this->Component->render(new DropdownMenu('People', [
                    new DropdownItem(
                        __('My Representatives'),
                        ['_name' => 'municipality:default', '#' => 'elected_officials'],
                        ['icon' => 'street-view']
                    ),
                    new DropdownItem(
                        __('Browse Representatives'),
                        ['_name' => 'politicians'],
                        ['icon' => (new User)->getIcon()]
                    ),
                ])) ?>
            </li>
            <li class="nav-item dropdown-md text-nowrap">
                <?= $this->Component->render(new DropdownMenu('Places', [
                    new DropdownItem(
                        __('My Municipality'),
                        ['_name' => 'municipality:default'],
                        ['icon' => 'street-view']
                    ),
                    new DropdownItem(
                        __('Browse Municipalities'),
                        (new ElectoralDistrict)->getBrowseRoute(),
                        ['icon' => (new User)->getIcon()]
                    ),
                ])) ?>
            <li class="nav-item dropdown-md text-nowrap">
                <?= $this->Component->render(new DropdownMenu('Virtual Ballot', [
                    new DropdownItem(
                        __('November 2018 NJ Elections'),
                        ['_name' => 'citizen:ballots'],
                        ['icon' => 'archive']
                    )
                ])) ?>
            </li>
        </ul>
    </div>

    <div class="flex-row ml-md-auto d-none d-md-flex">
        <?= $this->element('Search/bar') ?>

        <div class="navbar-expand-md">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
                    aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>


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
