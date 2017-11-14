<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Button\EditButton $editButton
 */
?>

<?= $this->Html->button(
    $editButton->getButtonTitle(),
    $editButton->getButtonUrl(),
    $editButton->getButtonOptions()
) ?>
