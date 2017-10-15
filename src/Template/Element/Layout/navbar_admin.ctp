<?php

use OurSociety\Model\Entity;
use OurSociety\Model\Entity\User;
use OurSociety\View\Component\Layout\DropdownItem;
use OurSociety\View\Component\Layout\DropdownMenu;
use OurSociety\View\Component\Layout\NavLink;

/**
 * @var \OurSociety\View\AppView $this
 * @var User|null $identity
 */

if ($identity === null):
    return;
endif;

if ($identity->isAdmin() === false):
    return;
endif;

$brandUrl = $identity->getDashboardRoute();
$showBrand = true;
if ($this->request->getParam('prefix') === 'admin'):
    $brandUrl = $identity->getDashboardRoute(User::ROLE_CITIZEN);
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
                <?= $this->Component->render(new NavLink('Admin Overview', $identity->getDashboardRoute())) ?>
            </li>
            <li class="nav-item dropdown">
                <?= $this->Component->render(new DropdownMenu('Reports', [
                    new DropdownItem(__('Analytics'), '/admin/analytics/dashboard', [
                        'icon' => 'line-chart',
                    ]),
                    new DropdownItem(__('Aspects'), '/admin/aspects/dashboard', [
                        'icon' => (new Entity\Category)->getIcon(),
                    ]),
                    //new DropdownItem(__('Citizens'), '/admin/citizens/dashboard', [
                    //    'icon' => (new Entity\User)->getIcon(),
                    //]),
                    //new DropdownItem(__('Politicians'), '/admin/politicians/dashboard', [
                    //    'icon' => (new Entity\User)->getIcon(),
                    //]),
                    new DropdownItem(__('Questions'), '/admin/questions/dashboard', [
                        'icon' => (new Entity\Question)->getIcon(),
                    ]),
                    new DropdownItem(__('Users'), '/admin/users/dashboard', [
                        'icon' => (new Entity\User)->getIcon(),
                    ]),
                    new DropdownItem(__('Values'), '/admin/value-matches/dashboard', [
                        'icon' => (new Entity\ValueMatch)->getIcon(),
                    ]),
                ])) ?>
            </li>
            <li class="nav-item dropdown">
                <?= $this->Component->render(new DropdownMenu('Tables', [
                    new DropdownItem(__('Answers'), '/admin/answers', [
                        'icon' => (new Entity\Answer)->getIcon(),
                    ]),
                    new DropdownItem(__('Articles'), '/admin/articles', [
                        'icon' => (new Entity\Article)->getIcon(),
                    ]),
                    new DropdownItem(__('Aspects'), '/admin/aspects', [
                        'icon' => (new Entity\Category)->getIcon(),
                    ]),
                    new DropdownItem(__('Aspects by User'), '/admin/aspects/users', [
                        'icon' => (new Entity\CategoriesUser)->getIcon(),
                    ]),
                    new DropdownItem(__('Events'), '/admin/events', [
                        'icon' => (new Entity\Event)->getIcon(),
                    ]),
                    new DropdownItem(__('Politician Awards'), '/admin/politician-awards', [
                        'icon' => (new Entity\PoliticianAward)->getIcon(),
                    ]),
                    new DropdownItem(__('Politician Positions'), '/admin/politician-positions', [
                        'icon' => (new Entity\PoliticianPosition)->getIcon(),
                    ]),
                    new DropdownItem(__('Politician Qualifications'), '/admin/politician-qualifications', [
                        'icon' => (new Entity\PoliticianQualification)->getIcon(),
                    ]),
                    new DropdownItem(__('Politician Videos'), '/admin/politician-videos', [
                        'icon' => (new Entity\PoliticianVideo)->getIcon(),
                    ]),
                    new DropdownItem(__('Questions'), '/admin/questions', [
                        'icon' => (new Entity\Question)->getIcon(),
                    ]),
                    new DropdownItem(__('Reports'), '/admin/reports', [
                        'icon' => (new Entity\Report)->getIcon(),
                    ]),
                    new DropdownItem(__('Submissions'), '/admin/submissions', [
                        'icon' => (new Entity\Submission)->getIcon(),
                    ]),
                    new DropdownItem(__('Users'), '/admin/users', [
                        'icon' => (new Entity\User)->getIcon(),
                    ]),
                    new DropdownItem(__('Value Matches'), '/admin/value-matches', [
                        'icon' => (new Entity\ValueMatch)->getIcon(),
                    ]),
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
