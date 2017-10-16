<?php

use Cake\Core\Configure;

/**
 * @var \OurSociety\View\AppView $this The view.
 */

$appName = Configure::read('App.name');
$isBeta = Configure::read('App.beta') ?? false;
$subtitle = $subtitle ?? 'βeta';
?>

<div class="os-logo">
    <svg class="align-middle" width="36" height="36" xmlns="http://www.w3.org/2000/svg" focusable="false">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/img/brand-sprite.svg#logo-white-transparent"></use>
    </svg>
    <?= $appName ?>
    <?php if ($isBeta): ?>
        <div class="beta-ribbon">
            <span><?= $subtitle ?></span>
        </div>
    <?php endif ?>
</div>
