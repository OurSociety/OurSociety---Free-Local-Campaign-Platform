<?php
/**
 * Show a citizen's virtual ballot for an election.
 *
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Contest[] $contests
 * @var \OurSociety\Model\Entity\Election $election
 * @var \OurSociety\Model\Entity\User $identity
 */

$this->set('title', 'Our Society Virtual Ballot');
$this->Breadcrumbs->add(__('My Dashboard'), $identity->getDashboardRoute());
$this->Breadcrumbs->add(__('Virtual Ballot'));
$this->Breadcrumbs->add($election->name);
?>

<h1>
    <?= __('Virtual Ballot') ?>
</h1>

<p>
    <?= __('Below is a "virtual" ballot displaying your candidates in the {electoral_district} area in the upcoming {election} election.', [
        'electoral_district' => $identity->electoral_district->renderLink($this),
        'election' => $election->renderLink($this),
    ]) ?>
</p>

<h2><?= $election->name ?></h2>

<?php if (count($contests) === 0): ?>
    <p>
        <?= __('There are no contests in this election.') ?>
    </p>
<?php else: ?>
    <p>
        <?= __('The following contests in this election apply to your area:') ?>
    </p>

    <?php foreach ($contests as $contest): ?>

        <div class="card mb-3">
            <div class="card-body pb-0">
                <h3>
                    <?= $contest->name ?>
                </h3>

                <?php if (count($contest->candidates) === 0): ?>
                    <p>
                        <?= __('No candidates have filed for this contest.') ?>
                    </p>
                <?php else: ?>
                    <p>
                        <?= __('The following candidates have filed for this contest:') ?>
                    </p>

                    <div class="row">
                        <?php foreach ($contest->candidates as $candidate): ?>

                            <?php
                            var_dump($candidate->politician->electoral_district_id, 'politician district');
                            var_dump($candidate->politician->office_type_id, 'politician office type');
                            var_dump($this->request->session()->read('Auth')->electoral_district_id, 'user district');
                            ?>
                            <?php if($candidate->politician->electoral_district_id == $this->request->session()->read('Auth')->electoral_district_id || $senate == $candidate->politician->office_type_id) : ?>
                            <div class="col-md-4">
                                <?= $candidate->renderSummaryElement($this) ?>
                            </div>
                        <?php endif; ?>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            </div>
        </div>

    <?php endforeach ?>
<?php endif ?>
