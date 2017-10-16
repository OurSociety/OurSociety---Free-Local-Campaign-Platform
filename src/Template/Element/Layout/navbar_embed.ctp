<?php

use Cake\Core\Configure;

/**
 * Embed layout.
 *
 * @var string $callToActionUrl
 */

$appName = Configure::read('App.name');
?>

<header class="os-embed-navbar navbar navbar-expand navbar-dark flex-row">
    <div class="col-auto mr-auto">
        <a href="<?= $callToActionUrl ?>" aria-label="OurSociety" class="navbar-brand">
            <svg class="align-middle" width="36" height="36" xmlns="http://www.w3.org/2000/svg" focusable="false">
                <use xmlns:xlink="http://www.w3.org/1999/xlink"
                     xlink:href="/img/brand-sprite.svg#logo-white-transparent"></use>
            </svg>
            <?= $appName ?>
        </a>
    </div>
    <div class="col-auto">
        <a href="<?= $callToActionUrl ?>" class="btn btn-os-yellow d-inline-block align-middle pull-right">
            <?= __('Get Matched') ?>
        </a>
    </div>
</header>
