<?php
/**
 * @var string $name The name of the user.
 * @var string $token The verification token.
 * @var \OurSociety\View\AppView $this
 */
?>
<?= __('Hi {0}', $name) ?>,

<?= __('Please copy the following address into your web browser') ?>:


<?= $this->Url->build($url, ['escape' => false]) ?>
