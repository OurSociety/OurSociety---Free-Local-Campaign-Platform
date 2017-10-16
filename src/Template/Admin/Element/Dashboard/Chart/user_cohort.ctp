<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var array[] $cohortTable
 */

$headings = array_shift($cohortTable);
?>

<div class="card os-number-widget">
    <h4 class="card-header">Active Users Cohort</h4>
    <table class="table">
        <thead>
        <tr>
            <th>Month</th>
            <?php foreach ($headings as $heading): ?>
                <th><?= $heading ?></th>
            <?php endforeach ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cohortTable as $month => $cohorts): ?>
            <tr>
                <th scope="row"><?= $month ?></th>
                <?php foreach ($cohorts as $cohort => $percent): ?>
                    <td><?= $percent !== null ? $this->Number->toPercentage($percent) : null ?></td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
