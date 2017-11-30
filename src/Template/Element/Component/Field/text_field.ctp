<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Field\TextField $textField
 */

$text = $this->Text->autoLink($textField->getText());
if (strpos($text, "\n") !== false) {
    $text = $this->Text->autoParagraph($text);
}
?>

<?= $text ?>
