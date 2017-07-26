<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $politician
 * @var \OurSociety\Model\Entity\User $currentUser
 */
?>
<ol class="breadcrumb">
    <li><?= $this->Html->dashboardLink() ?></li>
    <li><?= $this->Html->link('Politicians', ['_name' => 'politicians']) ?></li>
    <li><?= $this->Html->politicianLink($politician) ?></li>
    <li>Value Match</li>
</ol>

<h2>Value Match</h2>

<hr>

<p>
    <?= __('Your values in comparison to politician {politician_name}.', ['politician_name' => $politician->name]) ?>
</p>

<?= $this->cell('Profile/ValueMatch', [$politician, $currentUser, null]) ?>
