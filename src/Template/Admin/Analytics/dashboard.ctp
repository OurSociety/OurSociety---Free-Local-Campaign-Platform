<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 */
$this->Breadcrumbs->add('Dashboards', '/admin');
$this->Breadcrumbs->add('Analytics Dashboard');

//$this->extend('/Common/Dashboard/dashboard')
$defaultRange = 'week';
$ranges = [
    $defaultRange => __('Weekly'),
    'month' => __('Monthly'),
    'year' => __('Yearly'),
];
?>

<script>
    (function (w, d, s, g, js, fs) {
        g = w.gapi || (w.gapi = {});
        g.analytics = {
            q: [], ready: function (f) {
                this.q.push(f);
            }
        };
        js = d.createElement(s);
        fs = d.getElementsByTagName(s)[0];
        js.src = 'https://apis.google.com/js/platform.js';
        fs.parentNode.insertBefore(js, fs);
        js.onload = function () {
            g.load('analytics');
        };
    }(window, document, 'script'));
</script>

<?php $this->start('breadcrumb-actions') ?>
<div class="btn-group" role="group" aria-label="Basic example">
    <?php foreach ($ranges as $name => $label): ?>
        <?php
        $options = ['class' => ['btn', 'btn-light'], 'role' => 'button'];
        if ($this->request->getQuery('range') === $name) {
            $options['class'][] = 'active';
            $options['aria-pressed'] = true;
        }
        ?>
        <?= $this->Html->link($label, ['?' => ['range' => $name]], $options) ?>
    <?php endforeach ?>
</div>
<?php $this->end() ?>

<div class="row mb-3">
    <div class="col">
        <div id="active-users-container"></div>
    </div>
    <div class="col text-right">
        <a href="https://analytics.google.com/analytics/web/#embed/report-home/a102777595w150460175p155448145/"
           class="icon-ga pull-right mx-2">
        </a>
        <div id="embed-api-auth-container"></div>
    </div>
</div>

<div class="card mb-3 px-3" style="min-height: 200px">
    <div id="chart-container"></div>
</div>

<!--
<div class="row mb-3">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="Chartjs">
                    <h3>This Week vs Last Week (by sessions)</h3>
                    <figure class="Chartjs-figure" id="chart-1-container"></figure>
                    <ol class="Chartjs-legend" id="legend-1-container"></ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="Chartjs">
                    <h3>This Year vs Last Year (by users)</h3>
                    <figure class="Chartjs-figure" id="chart-2-container"></figure>
                    <ol class="Chartjs-legend" id="legend-2-container"></ol>
                </div>
            </div>
        </div>
    </div>
</div>
-->

<div class="row">
    <div class="col-6">
        <div class="card" style="min-height: 200px">
            <div class="card-body">
                <div id="chart-3-container"></div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card" style="min-height: 200px">
            <div class="card-body">
                <div id="chart-4-container"></div>
            </div>
        </div>
    </div>
</div>
