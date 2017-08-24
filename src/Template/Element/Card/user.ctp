<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $user
 */
?>

<div class="card text-white<?= $user->is_example === true ? ' example' : '' ?>">

    <?php if ($user->picture !== null): ?>
        <img class="card-img" src="<?= $user->picture ?>" alt="Card image">
    <?php else: ?>
        <?= $this->Html->jdenticon($user->id) ?>
    <?php endif ?>

    <div class="card-img-overlay text-center">
        <h5 class="card-title align-bottom" style="background: rgba(0,0,0,.5); margin: -1.25rem; padding: 1rem">
            <?= !$user->is_example
                ? $user->name
                : __('Your Name Here!') ?>
        </h5>
    </div>

</div>
