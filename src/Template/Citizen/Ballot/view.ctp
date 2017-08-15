<?php
/**
 * Show a citizen's virtual ballot for an election.
 *
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Contest[] $contests
 * @var \OurSociety\Model\Entity\Election $election
 * @var \OurSociety\Model\Entity\User $currentUser
 */
?>

<ol class="breadcrumb">
    <li><?= $this->Html->link(__('Citizen Dashboard'), ['_name' => 'citizen:dashboard']) ?></li>
    <li>Virtual Ballot</li>
    <li><?= $election->name ?></li>
</ol>

<h1>
    <?= __('Virtual Ballot') ?>
</h1>

<p>
    <?= __('Below is a "virtual" ballot displaying your candidates in the {electoral_district} area in the upcoming {election} election.', [
        'electoral_district' => $currentUser->electoral_district->renderLink($this),
        'election' => $election->renderLink($this),
    ]) ?>
</p>

<h2><?= $election->name ?></h2>

<p>
    <?= __('The following contests in this election apply to your area:') ?>
</p>

<?php foreach ($contests as $contest): ?>

    <h3>
        <?= $contest->name ?>
    </h3>

    <p>The following candidates have filed for this contest:</p>

    <div class="row">
        <?php foreach ($contest->candidates as $candidate): ?>
            <div class="col-md-4">
                <?= $candidate->renderCardElement($this) ?>
            </div>
        <?php endforeach ?>
    </div>

<?php endforeach ?>
