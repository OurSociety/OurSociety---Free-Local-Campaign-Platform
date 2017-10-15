<?php
/**
 * @var \OurSociety\View\AppView $this
 */

$this->extend('site');
?>

<?= $this->fetch('content') ?>

<?= $this->Html->link(__('Back'), 'javascript:history.back()') ?>
