<?php
/**
 * @var string $name The name of the user.
 * @var string $token The verification token.
 * @var \OurSociety\View\AppView $this
 */
?>
<p>
    <?= __('Hi {0}', $name) ?>,
</p>
<p>
    <strong><?= $this->Html->link(__('Activate your account here'), $url) ?></strong>
</p>
<p>
    <?= __('If the link is not correctly displayed, please copy the following address into your web browser') ?>:
</p>
<p>
    <?= $this->Url->build($url) ?>
</p>
