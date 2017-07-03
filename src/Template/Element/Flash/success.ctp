<?php
/**
 * @var string $message The flash message.
 * @var string[] $params The flash parameters.
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message success" onclick="this.classList.add('hidden')"><?= $message ?></div>
