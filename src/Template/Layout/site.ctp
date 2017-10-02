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

/** @var \Cake\Collection\Collection $links */
$links = collection([]);
if ($currentUser !== null):
    $links = $links->append([
        ['title' => __('My Dashboard'), 'url' => $currentUser->getDashboardRoute()],
        ['title' => __('My Municipality'), 'url' => ['_name' => 'municipality:default']],
    ]);
else:
    $links = $links->append([
        ['title' => __('Home'), 'url' => ['_name' => 'home']],
    ]);
endif;
$links = $links->append([
    ['title' => __('Municipalities'), 'url' => ['_name' => 'district', 'district' => 'new-jersey']],
    ['title' => __('Representatives'), 'url' => ['_name' => 'politicians']],
]);
?>

<header class="navbar navbar-expand navbar-dark flex-column flex-md-row os-navbar">
    <a href="<?= $this->Url->build(['_name' => 'home']) ?>" aria-label="OurSociety" class="navbar-brand">
        <?= $this->element('logo', ['showBeta' => true]) ?>
    </a>

    <div class="navbar-nav-scroll">
        <ul class="navbar-nav os-navbar-nav flex-row">
            <?php foreach ($links as $link): ?>
                <?php
                $liClasses = ['nav-item'];
                $requestPath = $this->request->getUri()->getPath();
                $linkPath = $this->Url->build($link['url']);
                if ($requestPath === $linkPath):
                    $liClasses[] = 'active';
                endif;
                ?>
                <li class="<?= implode(' ', $liClasses) ?> text-nowrap">
                    <?= $this->Html->link($link['title'], $link['url'], ['class' => ['nav-link']]) ?>
                </li>
            <?php endforeach ?>
        </ul>
    </div>

    <ul class="navbar-nav os-navbar-nav flex-row ml-md-auto d-none d-md-flex">
        <?php if ($currentUser !== null): ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-nowrap" href="#" id="navbarDropdownMenuLink"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= $currentUser->renderProfilePicture($this, [
                        'class' => ['align-middle', 'bg-light', 'rounded-circle', 'mr-2'],
                        'style' => 'height: 32px; width: 32px; border: 2px solid white'
                    ]) ?>
                    <?= $currentUser->name ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
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
            <!--
            <li class="nav-item">
                <?= $this->cell('Navbar/User') ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Sign Out'), ['_name' => 'users:logout'], [
                    'class' => ['btn', 'btn-os-yellow', 'd-none', 'd-lg-inline-block', 'mb-3', 'mb-md-0', 'ml-md-3']
                ]) ?>
            </li>
            -->
        <?php else: ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Sign In'), ['_name' => 'users:login'], [
                    'class' => ['btn', 'btn-os-yellow', 'd-none', 'd-lg-inline-block', 'mb-3', 'mb-md-0', 'ml-md-3']
                ]) ?>
            </li>
        <?php endif ?>
    </ul>

</header>

<?= $this->Breadcrumbs->render() ?>

<div class="<?= $containerClass ?? 'container my-4' ?>">

    <?= $this->Flash->render(); ?>

    <?= $this->fetch('content') ?>

</div>

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
