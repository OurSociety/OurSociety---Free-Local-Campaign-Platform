<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var User|null $currentUser
 */

use OurSociety\Model\Entity\User;
use OurSociety\View\Tag\Menu\DropdownItem;
use OurSociety\View\Tag\Menu\DropdownMenu;

if ($currentUser === null):
    return;
endif;

if ($currentUser->isAdmin() === false):
    return;
endif;

$brandUrl = $currentUser->getDashboardRoute();
$showBrand = true;
if ($this->request->getParam('prefix') === 'admin'):
    $brandUrl = $currentUser->getDashboardRoute(User::ROLE_CITIZEN);
endif;
?>

<div class="navbar navbar-expand navbar-dark bg-dark">
    <?php if ($showBrand): ?>
        <a href="<?= $this->Url->build($brandUrl) ?>"
           aria-label="OurSociety" class="navbar-brand">
            <?= $this->element('Layout/brand', ['subtitle' => 'Admin']) ?>
        </a>
    <?php endif ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
            aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active text-nowrap">
                <a class="nav-link" href="<?= $this->Url->build($currentUser->getDashboardRoute()) ?>">
                    Admin Overview
                    <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <?= $this->Tag->render(new DropdownMenu('Reports', [
                    new DropdownItem(__('Analytics'), '/admin/analytics/dashboard'),
                    new DropdownItem(__('Aspects'), '/admin/aspects/dashboard'),
                    //new DropdownItem(__('Citizens'), '/admin/citizens/dashboard'),
                    //new DropdownItem(__('Politicians'), '/admin/politicians/dashboard'),
                    new DropdownItem(__('Questions'), '/admin/questions/dashboard'),
                    new DropdownItem(__('Users'), '/admin/users/dashboard'),
                    new DropdownItem(__('Values'), '/admin/value-matches/dashboard'),
                ])) ?>
            </li>
            <li class="nav-item dropdown">
                <?= $this->Tag->render(new DropdownMenu('Tables', [
                    new DropdownItem(__('Answers'), '/admin/answers'),
                    new DropdownItem(__('Articles'), '/admin/articles'),
                    new DropdownItem(__('Aspects'), '/admin/aspects'),
                    new DropdownItem(__('Aspects by User'), '/admin/aspects/users'),
                    new DropdownItem(__('Events'), '/admin/events'),
                    new DropdownItem(__('Politician Awards'), '/admin/politician-awards'),
                    new DropdownItem(__('Politician Positions'), '/admin/politician-positions'),
                    new DropdownItem(__('Politician Qualifications'), '/admin/politician-qualifications'),
                    new DropdownItem(__('Politician Videos'), '/admin/politician-videos'),
                    new DropdownItem(__('Questions'), '/admin/questions'),
                    new DropdownItem(__('Users'), '/admin/users'),
                    new DropdownItem(__('Value Matches'), '/admin/value-matches'),
                ])) ?>
            </li>
            <!--
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Revert To Admin User</a>
            </li>
            -->
        </ul>

        <?= $this->cell('Navbar/User') ?>

        <?= $this->Html->link(__('Sign Out'), ['_name' => 'users:logout'], [
            'class' => ['btn', 'btn-os-yellow', 'd-none', 'd-lg-inline-block', 'mb-3', 'mb-md-0', 'ml-md-3'],
        ]) ?>
    </div>
</div>
