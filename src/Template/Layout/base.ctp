<?php
use Cake\I18n\I18n;

/**
 * @var \OurSociety\View\AppView $this The view class.
 */
?>
<!DOCTYPE html>
<html lang="<?= Locale::getPrimaryLanguage(I18n::locale()) ?>">
<head>
    <?= $this->Html->charset(); ?>
    <title><?= $this->get('title', 'OurSociety') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?= $this->Html->meta('icon', $this->Url->image('logo.png')); ?>
    <?= $this->fetch('meta'); ?>
    <?= $this->fetch('css'); ?>
    <?= $this->fetch('headjs'); ?>
</head>
<body class="<?= $this->fetch('scope') ?> <?= $this->fetch('theme') ?>">
    <?= $this->fetch('content') ?>
    <?= $this->fetch('modal'); ?>
    <?= $this->fetch('script'); ?>
</body>
</html>
