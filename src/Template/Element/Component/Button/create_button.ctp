<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Button\CreateButton $createButton
 */
?>

<?= $this->Html->button(
    $createButton->getButtonTitle(),
    $createButton->getButtonUrl(),
    $createButton->getButtonOptions()
) ?>
