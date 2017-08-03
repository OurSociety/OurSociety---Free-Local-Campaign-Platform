<?php
/**
 * Admin layout.
 *
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $currentUser The current user.
 * @var bool $disableSidebar True when the CrudView 'scaffold.sidebar_navigation' config is set to `false`.
 */
$this->extend('base');
$this->set('theme', 'bd-docs')
?>

<a id="skippy" class="sr-only sr-only-focusable" href="#content">
    <div class="container">
        <span class="skiplink-text">Skip to main content</span>
    </div>
</a>

<?= $this->element('Admin/header') ?>

<div class="row flex-xl-nowrap no-gutters">
    <?= $this->element('Admin/sidebar') ?>

    <div class="col">
        <div class="row flex-xl-nowrap no-gutters">
            <div class="col">
                <div class="row no-gutters os-bar-inner justify-content-between">
                    <div class="col align-self-center">
                        <?= $this->element('breadcrumbs') ?>
                    </div>

                    <div class="col align-self-center pr-1 text-right">
                        <?= $this->fetch('breadcrumb-actions') ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row no-gutters os-background">

            <?php if ($this->exists('actions')): ?>
                <div class="d-none d-xl-block col-xl-2 bd-toc">
                    <?= $this->element('Admin/toc') ?>
                </div>
            <?php endif ?>

            <main class="col p-md-3 bd-content" role="main">

                <?= $this->Flash->render() ?>

                <?= $this->fetch('content') ?>

                <?= $this->fetch('action_link_forms') ?>

            </main>
        </div>
    </div>
</div>
