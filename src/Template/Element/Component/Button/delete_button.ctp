<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Button\DeleteButton $deleteButton
 */
?>

<?= $this->Form->postLink(
    $deleteButton->getButtonTitle(),
    $deleteButton->getButtonUrl(),
    $deleteButton->getButtonOptions()
) ?>
