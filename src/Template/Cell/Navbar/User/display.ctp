<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $user
 * @var \OurSociety\Model\Entity\User[] $users
 * @var array $formOptions
 */

$this->start('user_signed_in');
    ?>
    <?= __('Signed in as {name}', [
        'name' => $this->Html->link(
            $user['name'],
            $user->isPathwayPolitician()
                ? ['_name' => 'citizen:profile']
                : ['_name' => 'users:profile'],
            ['class' => ['text-white']]
        )
    ]) ?>
    <?php
$this->end();

$this->start('user_switcher');
    ?>
    <?= $this->Form->create($user, $formOptions + [
            'url' => ['_name' => 'admin:users:switch'],
            'class' => ['form-inline'],
        ]) ?>
    <?= $this->Form->control('user', [
        'label' => false,
        'value' => $user->slug,
        'onchange' => 'if (this.value) this.form.submit()',
        'style' => 'margin-left: 8px;',
        'error' => false,
        'class' => ['js-selectize'],
    ]) ?>
    <?= $this->Form->end() ?>
    <?php
$this->end();
?>

<?php if ($users !== null): ?>
    <p class="d-sm-none visible-xs navbar-text">
        <?= $this->fetch('user_signed_in') ?>
    </p>
    <div class="hidden-xs hidden-sm">
        <?= $this->fetch('user_switcher') ?>
    </div>
<?php else: ?>
    <p class="navbar-text mb-0">
        <?= $this->fetch('user_signed_in') ?>
    </p>
<?php endif ?>
