<?php

use Cake\Collection\Collection;
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

/** @var Collection $links */
$links = collection([]);
if ($identity !== null):
    $links = $links->append([
        ['title' => __('My Dashboard'), 'url' => $identity->getDashboardRoute($identity->isAdmin() ? User::ROLE_CITIZEN : null)],
        ['title' => __('My Municipality'), 'url' => ['_name' => 'municipality:default']],
    ]);
else:
    $links = $links->append([
        ['title' => __('Home'), 'url' => ['_name' => 'root']],
    ]);
endif;
$links = $links->append([
    ['title' => __('Municipalities'), 'url' => (new ElectoralDistrict)->getBrowseRoute()],
    ['title' => __('Representatives'), 'url' => ['_name' => 'politicians']],
    //['title' => __('Elections'), 'url' => (new Election)->getBrowseRoute()],
]);
?>

<header class="navbar navbar-expand navbar-dark flex-column flex-md-row os-navbar">
    <a href="<?= $this->Url->build(['_name' => 'home']) ?>" aria-label="OurSociety" class="navbar-brand">
        <?= $this->element('Layout/brand') ?>
    </a>

    <div class="navbar-nav-scroll">
        <ul class="navbar-nav os-navbar-nav flex-wrap">
            <?php foreach ($links as $link): ?>
                <?php
                $liClasses = ['nav-item'];
                $requestPath = $this->request->getUri()->getPath();
                $linkPath = $this->Url->build($link['url']);
                if ($requestPath === $linkPath):
                    $liClasses[] = 'active';
                endif;
                $link += ['title' => 'Unknown', 'url' => '#', 'options' => []];
                ?>
                <li class="<?= implode(' ', $liClasses) ?> text-nowrap">
                    <?= $this->Component->render(new NavLink($link['title'], $link['url'], $link['options'])) ?>
                </li>
            <?php endforeach ?>
        </ul>
    </div>

    <div class="flex-row ml-md-auto d-none d-md-flex">
        <?= $this->element('Search/bar') ?>

        <?= $this->element('Layout/user_menu') ?>
    </div>

</header>
