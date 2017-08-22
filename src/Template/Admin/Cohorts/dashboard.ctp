<?php
/**
 * @var \OurSociety\View\AppView $this
 */

$this->Breadcrumbs->add('Dashboards', ['_name' => 'admin:dashboard']);
$this->Breadcrumbs->add('Cohorts');

$this->extend('/Common/Dashboard/dashboard');

$this->start('dashboard');
?>
<link href="https://d26b395fwzu5fz.cloudfront.net/keen-dataviz-1.0.1.css" rel="stylesheet">
<link href="https://rawgit.com/keen/cohorts/master/dist/keen-cohort-builder.css" rel="stylesheet">
<div class="card">
    <div class="card-body">
        <div id="cohort-chart"></div>
    </div>
    <div id="cohort-table"></div>
</div>


<!-- Cohort Builder relies on the Keen IO Dataviz SDK -->
<script src="https://d26b395fwzu5fz.cloudfront.net/keen-analysis-1.1.0.js"></script>
<script src="https://d26b395fwzu5fz.cloudfront.net/keen-dataviz-1.0.1.js"></script>

<!-- Cohort Builder JS -->
<script src="https://rawgit.com/keen/cohorts/master/dist/keen-cohort-builder.js"></script>
<!--<script src="--><?//= mix('js/') ?><!--"></script>-->
<script>
    var keenClient = new Keen({
        projectId: '<?= env('KEEN_IO_PROJECT_ID') ?>',
        readKey: '<?= env('KEEN_IO_READ_KEY') ?>'
    });

    var cohortChart = new Keen.Dataviz()
        .el('#cohort-chart')
        .height(100)
        .type('line');

    var cohortTable = new Keen.Dataviz()
        .el('#cohort-table')
        .library('cohort-builder')
        .type('matrix');

    var dateMatrix = Keen.CohortBuilder.generateDateMatrix('weeks', 5);
    var queryMatrix = Keen.CohortBuilder.generateCohortQueryMatrix(dateMatrix, function(cohort){
        return new Keen.Query('funnel', {
            steps: [
                {
                    event_collection: 'first_launch',
                    actor_property: 'dpid',
                    filters: [
                        { property_name: 'make', operator: 'eq', property_value: 'Apple' }
                    ],
                    timeframe: cohort.created_at
                },
                {
                    event_collection: 'application_opened',
                    actor_property: 'dpid',
                    filters: [
                        { property_name: 'make', operator: 'eq', property_value: 'Apple' }
                    ],
                    timeframe: cohort.current_interval
                }
            ]
        });
    });

    // Start first chart spinner
    cohortChart.prepare();
    Keen.CohortBuilder.fetchCohortDatasets(keenClient, queryMatrix, function(dataset) {
        cohortChart
            .data(dataset)
            .height(280)
            .render();

        cohortTable
            .data(dataset)
            .render();
    });
</script>
<?php $this->end() ?>
