<?php
/**
 * @var bool $showBeta True to show beta, false otherwise.
 */
?>
<div class="os-logo">
    <svg class="align-middle" width="36" height="36" xmlns="http://www.w3.org/2000/svg" focusable="false">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/img/brand-sprite.svg#logo-white-transparent"></use>
    </svg>
    OurSociety
    <?php if ($showBeta ?? false === true): ?>
        <div class="beta-ribbon">
            <span>βeta</span>
        </div>
    <?php endif ?>
</div>
