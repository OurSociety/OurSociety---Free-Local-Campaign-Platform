<?php
/**
 * Default layout.
 *
 * @var \OurSociety\View\AppView $this
 */
$this->extend('base');

/**
 * Page content block.
 */
$this->start('page');
?>
    <?= $this->Flash->render(); ?>
    <?= $this->fetch('content'); ?>
<?php
$this->end();

/**
 * Navbar block.
 */
$this->start('navbar');
?>
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <?= $this->Html->link(
                    $this->Html->image('banner.png', ['title' => $this->get('siteTitle'), 'alt' => 'Brand']),
                    '/',
                    ['class' => 'navbar-brand', 'escape' => false]
                ); ?>
            </div>
            <div class="navbar-right">
                <?php if ($this->get('currentUser')): ?>
                    <p class="navbar-text">Signed in as <a href="#" class="navbar-link">Ron Rivers</a></p>
                <?php else: ?>
                    <ul class="nav navbar-nav">
                        <li><a href="#">Login</a></li>
                    </ul>
                <?php endif ?>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="navbar-collapse collapse">
                    <?php // TODO: Add some hidden navigation items here ?>
                </div>
            </div>
        </div>
    </nav>
<?php
$this->end();

/**
 * Render layout.
 */
?>
<?= $this->fetch('navbar'); ?>
<div class="container">
    <?= $this->fetch('page') ?>
</div>
