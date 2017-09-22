<?php
/**
 * Admin header element.
 *
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\User $currentUser The currently logged in user.
 */
?>

<header class="navbar navbar-expand navbar-dark flex-column flex-md-row bd-navbar">
    <a href="<?= $this->Url->build(['_name' => 'home']) ?>" aria-label="OurSociety" class="navbar-brand">
        <svg class="align-middle" width="36" height="36" xmlns="http://www.w3.org/2000/svg" focusable="false">
            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/img/brand-sprite.svg#logo-white-transparent"></use>
        </svg>
        OurSociety
    </a>

    <div class="navbar-nav-scroll">
        <ul class="navbar-nav bd-navbar-nav flex-row">
            <?php if ($this->get('currentUser')): ?>
                <li class="nav-item<?= strpos($this->request->getUri()->getPath(), '/admin') === 0 ? ' active' : null ?>">
                    <?= $this->Html->dashboardLink($currentUser->role, __('My Dashboard'), ['class' => ['nav-link']]) ?>
                </li>
                <li class="nav-item<?= $this->request->getUri()->getPath() === '/municipality' ? ' active' : null ?>">
                    <?= $this->Html->link(__('My Municipality'), ['_name' => 'municipality:default'], ['class' => ['nav-link']]) ?>
                </li>
            <?php else: ?>
                <li class="nav-item<?= $this->request->getUri()->getPath() === '/home' ? ' active' : null ?>">
                    <?= $this->Html->link(__('Home'), ['_name' => 'home'], ['class' => ['nav-link']]) ?>
                </li>
            <?php endif ?>
            <li class="nav-item<?= $this->request->getUri()->getPath() === '/politicians' ? ' active' : null ?>">
                <?= $this->Html->link(__('Browse Politicians'), ['_name' => 'politicians'], ['class' => ['nav-link']]) ?>
            </li>
        </ul>
    </div>

    <ul class="navbar-nav bd-navbar-nav flex-row ml-md-auto d-none d-md-flex">
        <?php if ($this->get('currentUser')): ?>
            <li class="nav-item">
                <?= $this->cell('Navbar/User') ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Sign Out'), ['_name' => 'users:logout'], [
                    'class' => ['btn', 'btn-bd-yellow', 'd-none', 'd-lg-inline-block', 'mb-3', 'mb-md-0', 'ml-md-3']
                ]) ?>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Sign In'), ['_name' => 'users:login'], [
                    'class' => ['btn', 'btn-bd-yellow', 'd-none', 'd-lg-inline-block', 'mb-3', 'mb-md-0', 'ml-md-3']
                ]) ?>
            </li>
        <?php endif ?>
    </ul>

</header>
