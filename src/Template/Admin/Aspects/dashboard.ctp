<?php
/**
 * @var \OurSociety\View\AppView $this
 */

$this->Breadcrumbs->add('Dashboards', '/admin');
$this->Breadcrumbs->add('Aspects Dashboard');

$this->extend('/Common/Dashboard/dashboard');

$this->start('dashboard');
?>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">Answers by Value Aspect</div>
            <div class="card-body">
                <canvas id="chartCategories" height="400"></canvas>
            </div>
        </div>
    </div>
</div>
<?php $this->end() ?>
