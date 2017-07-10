<?php
/**
 * Default layout.
 *
 * @var \OurSociety\View\AppView $this The view class.
 * @var array $currentUser The current user.
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
                    $this->Html->image('../images/banner.png', ['title' => $this->get('siteTitle'), 'alt' => 'Brand']),
                    ['_name' => 'pages:home'],
                    ['class' => 'navbar-brand', 'escape' => false]
                ); ?>
            </div>
            <div class="navbar-right">
                <?php if ($this->get('currentUser')): ?>
                    <p class="navbar-text text-muted small">
                        <?= __('Signed in as {name}', [
                            'name' => $this->Html->link(
                                $currentUser['name'],
                                ['_name' => 'users:profile']
                            )
                        ]) ?>
                    </p>
                    <?=''// $this->element('topbar'); ?>
                    <ul class="nav navbar-nav">
                        <li><?= $this->Html->link('Citizen', ['_name' => 'citizen:dashboard']) ?></li>
                        <li><?= $this->Html->link('Politician', ['_name' => 'politician:dashboard']) ?></li>
                        <li><?= $this->Html->link('Admin', ['_name' => 'admin:dashboard']) ?></li>
                        <li><?= $this->Html->link('Logout', ['_name' => 'users:logout']) ?></li>
                    </ul>
                <?php else: ?>
                    <ul class="nav navbar-nav">
                        <li><?= $this->Html->link('Login', ['_name' => 'users:login']) ?></li>
                    </ul>
                <?php endif ?>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
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
