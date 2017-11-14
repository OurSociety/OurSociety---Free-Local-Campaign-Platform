<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var string $message The message.
 * @var array $params The parameters.
 */

$class = array_unique((array)$params['class']);
$message = (isset($params['escape']) && $params['escape'] === false) ? $message : h($message);

$message = json_encode([
    'message' => $message,
    'style' => str_replace('alert-', '', array_pop($class)),
]);

$script = <<<JS
    flash.push(${message})
JS;

$this->Html->scriptBlock($script, ['block' => true]);
