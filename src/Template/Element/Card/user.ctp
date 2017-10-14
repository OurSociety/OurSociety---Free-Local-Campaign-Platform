<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $user
 */
?>

<?php $this->start('card_contents') ?>
    <?= $user->renderProfilePicture($this, ['class' => 'card-img']) ?>

    <div class="card-img-overlay text-center">
        <h5 class="card-title align-bottom" style="background: rgba(0,0,0,.5); margin: -1.25rem; padding: 1rem">
            <?= $user->printName() ?>
        </h5>
    </div>
<?php $this->end() ?>

<?php $this->start('card') ?>
    <a class="card text-white" href="<?= $this->Url->build($user->getCommunityContributorProfileRoute()) ?>">
        <?= $this->fetch('card_contents') ?>
    </a>
<?php $this->end() ?>

<?php $this->start('card_example') ?>
    <div class="card text-white example">
        <?= $this->fetch('card_contents') ?>
    </div>
<?php $this->end() ?>

<?php if ($user->is_example === true): ?>
    <?= $this->fetch('card_example') ?>
<?php else: ?>
    <?= $this->fetch('card') ?>
<?php endif ?>
