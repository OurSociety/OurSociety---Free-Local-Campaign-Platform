<?php
/**
 * Show a citizen's virtual ballot for an election.
 *
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $currentUser
 * @var \OurSociety\Model\Entity\Election[] $elections
 */
?>

<ol class="breadcrumb">
    <li><?= $this->Html->link(__('Citizen Dashboard'), ['_name' => 'citizen:dashboard']) ?></li>
    <li><?= __('Virtual Ballot') ?></li>
</ol>

<h1>
    <?= __('Virtual Ballot') ?>
</h1>

<p>
    <?= __('There are multiple upcoming elections for the district {district_summary}.', [
        'district_summary' => $currentUser->electoral_district->renderSummaryElement($this),
    ]) ?>
</p>

<h2>
    <?= __('Choose an election') ?>
</h2>

<p>
    <?= __('Please choose the election you wish to view your virtual ballot for.') ?>
</p>

<ul>
    <?php foreach ($elections as $election): ?>
        <li>
            <?= $election->renderSummaryElement($this, [
                'url' => ['_name' => 'citizen:ballot', 'election' => $election->slug]
            ]) ?>
        </li>
    <?php endforeach ?>
</ul>
