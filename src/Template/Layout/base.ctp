<?php

use Cake\Core\Configure;
use Cake\I18n\I18n;

/**
 * @var \OurSociety\View\AppView $this The view class.
 */

$title = Configure::readOrFail('App.name');
?>
<!DOCTYPE html>
<html lang="<?= Locale::getPrimaryLanguage(I18n::getLocale()) ?>">
<head>
    <?= $this->Html->charset(); ?>
    <title><?= $this->get('title', 'OurSociety') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php // Add new tags below this line, and below Google Analytics ?>
    <?= $this->element('Snippets/google_analytics') ?>
    <?= $this->element('Snippets/favicon') ?>
    <?= $this->Html->meta('csrf-token', $this->request->getParam('_csrfToken')); ?>
    <?= $this->fetch('meta'); ?>
    <?= $this->fetch('css'); ?>
    <?= $this->fetch('headjs'); ?>
    <?= $this->element('Snippets/keen_io'); ?>
</head>
<body class="<?= $this->fetch('scope') ?> <?= $this->fetch('theme') ?>">
<?= $this->fetch('content') ?>
<?= $this->fetch('modal'); ?>
<?= $this->fetch('script'); ?>
</body>
</html>
