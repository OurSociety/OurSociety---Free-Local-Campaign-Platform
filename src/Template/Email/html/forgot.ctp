<?php
/**
 * @var string $name The name of the user.
 * @var string $token The verification token.
 * @var array $url The reset password URL.
 * @var \OurSociety\View\AppView $this
 */
?>
<p>
    <?= __('Hi {0}', $name) ?>,
</p>
<p>
    <?= __('Your verification code is: {token}', ['token' => $token]) ?>
</p>
<p>
    <strong><?= $this->Html->link(__('Reset your password here'), $url) ?></strong>
</p>
<p>
    <?= __('If the link is not correctly displayed, please copy the following address into your web browser') ?>:
</p>
<p>
    <?= $this->Url->build($url) ?>
</p>
