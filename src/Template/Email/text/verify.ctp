<?php
/**
 * @var string $name The name of the user.
 * @var string $token The verification token.
 */
?>
<?= __('Hi {0}', $name) ?>,

<?= __('Please copy the following address into your web browser') ?>:

<?= $this->Url->build(['_full' => true, '_name' => 'users:verify', $token]) ?>
