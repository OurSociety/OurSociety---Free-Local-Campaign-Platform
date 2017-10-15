<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Button\ViewButton $viewButton
 */
?>

<?= $this->Html->button(
    $viewButton->getButtonTitle(),
    $viewButton->getButtonUrl(),
    $viewButton->getButtonOptions()
) ?>
