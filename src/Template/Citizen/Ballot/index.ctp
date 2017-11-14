<?php
/**
 * Show a citizen's virtual ballot for an election.
 *
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $identity
 * @var \OurSociety\Model\Entity\Election[] $elections
 */

$electionCount = count($elections);
?>

<ol class="breadcrumb">
    <li><?= $this->Html->link(__('Citizen Dashboard'), ['_name' => 'citizen:dashboard']) ?></li>
    <li><?= __('Virtual Ballot') ?></li>
</ol>

<h1>
    <?= __('Virtual Ballot') ?>
</h1>

<?php if ($electionCount === 0): ?>
    <p>
        <?= __('There are no upcoming elections for {place}.', [
            'place' => $identity->electoral_district->renderLink($this),
        ]) ?>
    </p>
<?php else: ?>
    <p>
        <?= __n(
            'There is one upcoming election for {place}.',
            'There are {count} upcoming elections for {place}.',
            $electionCount,
            ['count' => $electionCount, 'place' => $identity->electoral_district->renderLink($this)]
        ) ?>
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
                    'url' => ['_name' => 'citizen:ballot', 'election' => $election->slug],
                ]) ?>
            </li>
        <?php endforeach ?>
    </ul>
<?php endif ?>
