<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $user
 * @var \OurSociety\Model\Entity\User[] $users
 * @var array $formOptions
 */
?>
<?php if ($users !== null): ?>
    <p class="d-sm-none visible-xs navbar-text text-muted">
        <?= __('Signed in as {name}', [
            'name' => $this->Html->link(
                $user['name'],
                ['_name' => 'users:profile']
            )
        ]) ?>
    </p>
    <?= $this->Form->create($user, $formOptions + [
        'url' => ['_name' => 'admin:users:switch'],
        'class' => ['form-inline', 'hidden-xs', 'hidden-sm'],
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
<?php else: ?>
    <p class="navbar-text text-muted">
        <?= __('Signed in as {name}', [
            'name' => $this->Html->link(
                $user['name'],
                ['_name' => 'users:profile']
            )
        ]) ?>
    </p>
<?php endif ?>
