<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $politician The politician.
 */

$this->Breadcrumbs->add(__('Representatives'), ['_name' => 'politicians']);
$this->Breadcrumbs->add($politician->name, ['_name' => 'politician', 'politician' => $politician->slug]);
$this->Breadcrumbs->add(__('Claim Profile'));
?>

<h2>Claim Your Profile</h2>

<hr>

<p>
    <?= __('To claim the profile for {politician_name}, you must enter the activation code you received through the mail.', [
        'politician_name' => $this->Html->tag('strong', $politician->name),
    ]) ?>
</p>

<p class="text-muted">
    <?= __('If you have not received a code, please {contact_link} to verify your identity.', [
        'contact_link' => $this->Html->link(
            __('contact us'),
            sprintf('mailto:team@oursociety.org?subject=Profile+Claim+for+%s', urlencode($politician->name))
        ),
    ]) ?>
</p>

<section class="well well-lg">
    <?= $this->Form->create($politician) ?>
    <fieldset>
        <legend><?= __('Please enter your activation code') ?></legend>
        <?= $this->Form->control('token', [
            'label' => __('Activation code'),
            'value' => $this->request->getData('token'),
            'help' => 'The activation code is a 6-digit code you will have received through the mail.',
            'pattern' => '\d{6}',
        ]) ?>
        <?= $this->Form->control('email', [
            'label' => __('Email address'),
            'help' => 'The email address you wish to use for signing in to OurSociety. This will also be displayed to citizens.',
            'value' => $politician->email_temp,
        ]) ?>
        <?= $this->Form->control('password', [
            'help' => 'The password you wish to use when signing in to OurSociety in the future.',
            'value' => $this->request->getData('password'),
        ]) ?>
    </fieldset>
    <?= $this->Form->submit(__('Claim Profile')) ?>
    <?= $this->Form->end() ?>
</section>
