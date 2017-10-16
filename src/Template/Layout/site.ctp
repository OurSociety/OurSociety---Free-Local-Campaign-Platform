<?php
/**
 * Embed layout.
 *
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $currentUser The current user.
 */

$this->extend('base');
?>

<main>
    <?= $this->element('Layout/navbar_admin') ?>

    <?= $this->element('Layout/navbar') ?>

    <?= $this->Breadcrumbs->render() ?>

    <div class="<?= $containerClass ?? 'container my-4' ?>">

        <?= $this->Flash->render(); ?>

        <?= $this->fetch('content') ?>

    </div>
</main>

<?= $this->element('Layout/footer') ?>
