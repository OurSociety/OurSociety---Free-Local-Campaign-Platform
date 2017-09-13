<?php
/**
 * Embed layout.
 *
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $currentUser The current user.
 */
$this->extend('base');

$callToActionLink = $this->Url->build([
    '_name' => 'users:register',
    '?' => [
        'redirect' => $this->Url->build(['_name' => 'citizen:questions'])
    ]
]);
?>

<header class="navbar navbar-expand navbar-dark flex-column flex-md-row os-navbar">
    <a href="<?= $this->Url->build(['_name' => 'pages:home']) ?>" aria-label="OurSociety" class="navbar-brand">
        <svg class="align-middle" width="36" height="36" xmlns="http://www.w3.org/2000/svg" focusable="false">
            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/img/brand-sprite.svg#logo-white-transparent"></use>
        </svg>
        OurSociety
    </a>

    <div class="navbar-nav-scroll">
        <ul class="navbar-nav os-navbar-nav flex-row">
            <?php if ($this->get('currentUser')): ?>
                <li class="nav-item<?= $this->request->getUri()->getPath() === '/citizen' ? ' active' : null ?>">
                    <?= $this->Html->dashboardLink($currentUser->role, __('My Dashboard'), ['class' => ['nav-link']]) ?>
                </li>
                <li class="nav-item<?= $this->request->getUri()->getPath() === '/municipality' ? ' active' : null ?>">
                    <?= $this->Html->link(__('My Municipality'), ['_name' => 'municipality:default'], ['class' => ['nav-link']]) ?>
                </li>
                <li class="nav-item<?= $this->request->getUri()->getPath() === '/politicians' ? ' active' : null ?>">
                    <?= $this->Html->link(__('Browse Politicians'), ['_name' => 'politicians'], ['class' => ['nav-link']]) ?>
                </li>
            <?php else: ?>
                <li class="nav-item"><?= $this->Html->link(__('Home'), ['_name' => 'pages:home'], ['class' => ['nav-link']]) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Politicians'), ['_name' => 'politicians'], ['class' => ['nav-link']]) ?></li>
            <?php endif ?>
        </ul>
    </div>

    <?php if ($this->get('currentUser')): ?>
        <ul class="navbar-nav os-navbar-nav flex-row ml-md-auto d-none d-md-flex">
            <li class="nav-item">
                <?= $this->cell('Navbar/User') ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Logout'), ['_name' => 'users:logout'], [
                    'class' => ['btn', 'btn-os-yellow', 'd-none', 'd-lg-inline-block', 'mb-3', 'mb-md-0', 'ml-md-3']
                ]) ?>
            </li>
        </ul>
    <?php else: ?>
        <?= $this->Html->link(__('Login'), ['_name' => 'users:login'], [
            'class' => ['btn', 'btn-os-yellow', 'd-none', 'd-lg-inline-block', 'mb-3', 'mb-md-0', 'ml-md-3']
        ]) ?>
    <?php endif ?>

</header>

<main id="content">
    <div class="container my-5">
        <main class="os-content">
            <?= $this->Flash->render(); ?>
            <?= $this->fetch('content') ?>
        </main>
    </div>
</main>

<footer class="os-footer text-muted">
    <div class="container-fluid p-3 p-md-5">
        <ul class="os-footer-links">
            <li><?= $this->Html->link(__('About'), 'http://oursociety.org/purpose.php') ?></li>
            <li><?= $this->Html->link(__('Team'), 'http://oursociety.org/team.php') ?></li>
            <li><?= $this->Html->link(__('Terms'), '/tos') ?></li>
        </ul>
        <p>&copy; OurSociety &ndash; a 501(c)(3) company.</p>
    </div>
</footer>
