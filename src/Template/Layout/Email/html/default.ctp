<?php
/**
 * @var \OurSociety\View\AppView $this
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
    <title><?= $this->fetch('title') ?></title>
</head>
<body>
    <?= $this->fetch('content') ?>
    <p><?= __('Thank you') ?>,</p>
    <p><?= __('OurSociety Team') ?></p>
</body>
</html>
