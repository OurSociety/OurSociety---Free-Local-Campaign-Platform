<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Button\ShowButton $showButton
 */
?>

<?= $this->Html->button(
    $showButton->getButtonTitle(),
    $showButton->getButtonUrl(),
    $showButton->getButtonOptions()
) ?>
