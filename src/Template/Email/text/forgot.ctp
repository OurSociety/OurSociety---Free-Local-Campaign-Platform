<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var string $name The name of the user.
 * @var string $token The verification token.
 * @var array $url The reset password URL.
 */
?>
<?= __('Hi {name}', ['name' => $name]) ?>,

<?= __('Your verification code is: {token}', ['token' => $token]) ?>


<?= __('Alternatively, click or copy the following address into your web browser:') ?>


<?= $this->Url->build($url, ['escape' => false]) ?>
