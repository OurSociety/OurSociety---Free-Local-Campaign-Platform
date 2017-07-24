<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $user
 * @var \OurSociety\Model\Entity\Users $users
 */
?>
<?php if ($users !== null): ?>
    <?= $this->Form->create($user, [
        'url' => ['_name' => 'admin:users:switch'],
        'class' => ['form-inline'],
        'style' => 'float: left; margin-top: 8px;',
    ]) ?>
    <?= $this->Form->control('user', [
        'label' => __('Signed in as'),
        'value' => $user->slug,
        'onchange' => 'this.form.submit()',
        'style' => 'margin-left: 8px;',
    ]) ?>
    <?= $this->Form->end() ?>
<?php else: ?>
    <p class="navbar-text text-muted small">
        <?= __('Signed in as {name}', [
            'name' => $this->Html->link(
                $user['name'],
                ['_name' => 'users:profile']
            )
        ]) ?>
    </p>
<?php endif ?>