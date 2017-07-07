<section class="users form">
    <?= $this->Form->create('User') ?>
    <fieldset>
        <legend><?= __('Please enter your email to reset your password') ?></legend>
        <?= $this->Form->control('email') ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')); ?>
    <?= $this->Form->end() ?>
</section>
