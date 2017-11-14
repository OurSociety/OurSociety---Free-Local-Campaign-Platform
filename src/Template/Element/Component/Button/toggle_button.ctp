<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Button\ToggleButton $toggleButton
 */
?>

<?= $this->Form->postButton(
    $toggleButton->getButtonTitle(),
    $toggleButton->getButtonUrl(),
    $toggleButton->getButtonOptions()
) ?>
