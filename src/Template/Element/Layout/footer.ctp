<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 */
?>

<footer class="os-footer os-footer-sticky my-5 text-muted">
    <div class="container-fluid p-3 p-md-5">
        <ul class="os-footer-links">
            <li><?= $this->Html->link(__('About'), '/purpose') ?></li>
            <li><?= $this->Html->link(__('Team'), '/team') ?></li>
            <li><?= $this->Html->link(__('Terms'), '/tos') ?></li>
        </ul>
        <p>
            <?= __('OurSociety Inc. is a non-partisan, non-political 501(c)(3) charitable organization.') ?>
            <?= __('EIN number 82-1919398') ?>
        </p>
    </div>
</footer>
