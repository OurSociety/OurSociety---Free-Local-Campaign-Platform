<?php
/**
 * Public list of elections.
 *
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\Election[] $elections
 */
?>
<ol class="breadcrumb">
    <li><?= __('Elections') ?></li>
</ol>

<h1>
    <?= __('Elections') ?>
</h1>

<p>
    <?= __('This is a list of elections currently tracked by OurSociety.') ?>
</p>

<ul>
    <?php foreach ($elections as $election): ?>
    <li>
        <?= $election->renderSummaryElement($this) ?>
    </li>
    <?php endforeach ?>
</ul>
