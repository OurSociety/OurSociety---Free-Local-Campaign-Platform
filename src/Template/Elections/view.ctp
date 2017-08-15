<?php
/**
 * Public list of elections.
 *
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\Election $election
 */
?>
<ol class="breadcrumb">
    <li><?= $this->Html->link(__('Elections'), ['_name' => 'elections']) ?></li>
    <li><?= $election->name ?></li>
</ol>

<h1>
    <?= $election->name ?>
</h1>

<div class="row">
    <div class="col-md-6">
        <h2>Contests</h2>
        <?php if (count($election->contests) === 0): ?>
            <?php __('We have not added any contests for this election.') ?>
        <?php else: ?>
            <ul>
                <?php foreach ($election->contests as $contest): ?>
                    <li><?= $this->Html->link($contest->name, [
                        '_name' => 'election:contest',
                        'election' => $election->slug,
                        'contest' => $contest->slug,
                    ]) ?></li>
                <?php endforeach ?>
            </ul>
        <?php endif ?>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Election information
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <dl>
                            <dt>Date</dt>
                            <dd><?= $election->date ?></dd>
                            <dt>State</dt>
                            <dd><?= $this->Html->link($election->state->name, '#') ?></dd>
                            <dt>Election type</dt>
                            <dd><?= $election->election_type ?: '<span class="label label-default">Unknown</span>' ?></dd>
                            <dt>State-wide</dt>
                            <dd><?= $election->is_state_wide ? __('This is a state-wide election.') : __('This is a local election.') ?></dd>
                            <dt>Registration info</dt>
                            <dd><?= $election->registration_info ?: '<span class="label label-default">Unknown</span>' ?></dd>
                            <dt>Absentee ballot info</dt>
                            <dd><?= $election->absentee_ballot_info ?: '<span class="label label-default">Unknown</span>' ?></dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl>
                            <dt>Results</dt>
                            <dd><?= $election->results_uri ?: '<span class="label label-default">N/A</span>' ?></dd>
                            <dt>Hours open</dt>
                            <dd><?= $election->hours_open_id ?: '<span class="label label-default">Unknown</span>' ?></dd>
                            <dt>Has election day registration?</dt>
                            <dd><?= $election->has_election_day_registration ?: '<span class="label label-default">Unknown</span>' ?></dd>
                            <dt>Registration deadline</dt>
                            <dd><?= $election->registration_deadline ?: '<span class="label label-default">Unknown</span>' ?></dd>
                            <dt>Absentee request deadline</dt>
                            <dd><?= $election->absentee_request_deadline ?: '<span class="label label-default">Unknown</span>' ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
debug($election);
