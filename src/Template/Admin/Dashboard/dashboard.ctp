<?php
/**
 * @var \OurSociety\View\AppView $this
 */

$this->Breadcrumbs->add('Dashboards');
$this->Breadcrumbs->add('Dashboard Overview');

$this->extend('/Common/Dashboard/dashboard');

$this->start('dashboard');
$numbers = [
    ['name' => 'questions_answered_total', 'label' => 'Total Questions Answered', 'style' => 'pink', 'icon' => 'percent'],
    ['name' => 'questions_answered_citizens', 'label' => 'Questions Answered by Citizen', 'style' => 'green', 'icon' => 'percent'],
    ['name' => 'questions_answered_politicians', 'label' => 'Questions Answered by Politician', 'style' => 'blue', 'icon' => 'percent'],
    //['name' => 'questions_percentage_total', 'label' => 'Percentage', 'style' => 'blue', 'icon' => 'percent'],
    //['name' => 'questions_percentage_citizens', 'label' => 'Percentage by Citizen', 'style' => 'pink', 'icon' => 'percent'],
    //['name' => 'questions_percentage_politicians', 'label' => 'Percentage by Politician', 'style' => 'pink', 'icon' => 'percent'],
];
?>
<div class="row pb-6">
    <?php foreach ($numbers as $number): ?>
        <!--<div class="col-6 col-sm-4 col-xl-2">-->
        <div class="col">
            <?= $this->cell(
                'Dashboard/NumberWidget',
                [],
                ['period' => $this->request->getQuery('range', 'week')] + $number
            ) ?>
        </div>
    <?php endforeach ?>
</div>

<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <canvas id="chartVotes" width="400" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <canvas id="myChart" width="400" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <canvas id="chartVotes" width="400" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <canvas id="chartVotes" width="400" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <canvas id="myChart" width="400" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<?php $this->end() ?>
