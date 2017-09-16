<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var string $message The message.
 * @var array $params The parameters.
 */

$class = array_unique((array)$params['class']);
$message = (isset($params['escape']) && $params['escape'] === false) ? $message : h($message);

if (in_array('alert-dismissible', $class, true)) {
    $button = <<<BUTTON
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
BUTTON;
    $message = $button . $message;
}
?>

<?= $this->Html->div($class, $message, $params['attributes']) ?>
