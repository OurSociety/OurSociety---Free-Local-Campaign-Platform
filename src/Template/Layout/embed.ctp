<?php
/**
 * Embed layout.
 *
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $currentUser The current user.
 */
$this->extend('base');
?>
<div class="container">
    <div id="app" class="view" style="zoom: .5;
     -moz-transform: scale(.5);
     -moz-transform-origin: 0 0;">
        <?= $this->fetch('content'); ?>
    </div>
</div>
<?=''// $this->Html->css('embed') ?>
