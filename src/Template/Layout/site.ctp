<?php
/**
 * Embed layout.
 *
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $identity The current user.
 */

$this->extend('base');
?>

<main>
    <?= $this->element('Layout/navbar_admin') ?>

    <?= $this->element('Layout/navbar') ?>

    <?php if ($this->get('showSignUp')): ?>
        <?= $this->element('../Users/register') ?>
    <?php else: ?>
        <?= $this->Breadcrumbs->render() ?>
    <?php endif ?>

    <div class="<?= $containerClass ?? 'container my-4' ?>">

        <?= $this->Flash->render(); ?>

        <?= $this->fetch('content') ?>

    </div>
</main>

<?= $this->element('Layout/footer') ?>
