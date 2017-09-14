<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $user
 */
?>

<?php if ($user->is_example === true): ?>
    <div class="card text-white example">
<?php else: ?>
    <a class="card text-white" href="<?= $this->Url->build([
        '_name' => 'pathway-politician',
        'citizen' => $user->slug,
    ]) ?>">
<?php endif ?>

        <?= $this->Html->image($user, ['class' => 'card-img']) ?>

        <div class="card-img-overlay text-center">
            <h5 class="card-title align-bottom" style="background: rgba(0,0,0,.5); margin: -1.25rem; padding: 1rem">
                <?= !$user->is_example
                    ? $user->name
                    : __('Your Name Here!') ?>
            </h5>
        </div>

<?php if ($user->is_example === true): ?>
    </div>
<?php else: ?>
    </a>
<?php endif ?>
