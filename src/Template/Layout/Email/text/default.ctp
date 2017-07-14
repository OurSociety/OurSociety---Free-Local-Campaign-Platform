<?php
/**
 * @var \OurSociety\View\AppView $this
 */
?>
<?= implode(PHP_EOL . PHP_EOL, [
    $this->fetch('content'),
    __('Thank you') . ',',
    __('OurSociety Team'),
]) ?>
