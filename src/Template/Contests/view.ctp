<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\Contest $contest The contest.
 */
?>

    <ol class="breadcrumb">
        <li><?= $this->Html->link(__('Elections'), ['_name' => 'elections']) ?></li>
        <li><?= $contest->election->renderLink($this) ?></li>
        <li><?= $contest->name ?></li>
    </ol>

    <h1>
        <?= $contest->name ?>
    </h1>

    <p>
        <?= __('Information about the contest for {contest_name} in the election: {election_name}.', [
            'contest_name' => $contest->name,
            'election_name' => $contest->election->name,
        ]) ?>
    </p>

    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Contest information
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <dl>
                                <?php if ($contest->election): ?>
                                    <dt>Election</dt>
                                    <dd><?= $contest->election->renderSummaryElement($this) ?></dd>
                                <?php endif ?>
                                <?php if ($contest->electoral_district): ?>
                                    <dt>Electoral district <small>the geographical scope of the contest</small></dt>
                                    <dd><?= $contest->electoral_district->renderSummaryElement($this) ?></dd>
                                <?php endif ?>
                                <?php if ($contest->name): ?>
                                    <dt>Name of the contest, not necessarily how it appears on the ballot.</dt>
                                    <dd><?= $contest->name ?></dd>
                                <?php endif ?>
                                <?php if ($contest->abbreviation): ?>
                                    <dt>An abbreviation for the contest.</dt>
                                    <dd><?= $contest->abbreviation ?></dd>
                                <?php endif ?>
                                <?php if ($contest->number_elected): ?>
                                    <dt>Number of candidates that are elected in the contest (i.e. “N” of N-of-M).</dt>
                                    <dd><?= $contest->number_elected ?></dd>
                                <?php endif ?>
                                <?php if ($contest->votes_allowed): ?>
                                    <dt>Maximum number of votes/write-ins per voter in this contest.</dt>
                                    <dd>
                                        <?= $this->Html->pluralize(
                                            'Voters may make exactly {number} {noun} in this contest.',
                                            'selection',
                                            $contest->votes_allowed
                                        ) ?>
                                    </dd>
                                <?php endif ?>
                                <?php if ($contest->ballot_title): ?>
                                    <dt>Title of the contest as it appears on the ballot.</dt>
                                    <dd><?= $contest->ballot_title ?></dd>
                                <?php endif ?>
                                <?php if ($contest->ballot_sub_title): ?>
                                    <dt>Subtitle of the contest as it appears on the ballot.</dt>
                                    <dd><?= $contest->ballot_sub_title ?></dd>
                                <?php endif ?>
                                <?php if ($contest->electorate_specification): ?>
                                    <dt>Specifies any changes to the eligible electorate for this contest past the usual, “all registered voters” electorate. This subtag will most often be used for primaries and local elections. In primaries, voters may have to be registered as a specific party to vote, or there may be special rules for which ballot a voter can pull. In some local elections, non-citizens can vote.</dt>
                                    <dd><?= $contest->electorate_specification ?></dd>
                                <?php endif ?>
                                <?php if ($contest->has_rotation): ?>
                                    <dt>Selection rotation</dt>
                                    <dd><?= $contest->has_rotation
                                            ? __('Our data indicates that the selections will be rotated on ballots and will likely appear in a different order than indicated on our website.')
                                            : __('Our data indicates that the selections will not be rotated on ballots and may therefore appear in the same order as listed on our website.') ?></dd>
                                <?php endif ?>
                                <?php if ($contest->vote_variation): ?>
                                    <dt>Vote variation associated with the contest (e.g. n-of-m, majority, et al).</dt>
                                    <dd><?= $contest->vote_variation->renderSummaryElement($this) ?></dd>
                                <?php endif ?>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
debug($contest);
