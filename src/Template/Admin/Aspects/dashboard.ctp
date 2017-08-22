<?php
/**
 * @var \OurSociety\View\AppView $this
 */

$this->Breadcrumbs->add('Dashboards', '/admin');
$this->Breadcrumbs->add('Aspects Dashboard');

$this->extend('/Common/Dashboard/dashboard');

$this->start('dashboard');

$labels = $data = [];
foreach (\OurSociety\Model\Table\DashboardTotalsTable::getRows('answers', 'aspect') as $row) {
    $labels[] = $row['name'];
    $data[] = $row['count'];
}
?>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">Answers by Value Aspect</div>
            <div class="card-body">
                <canvas id="chartCategories" height="<?= count($data) * 10 ?>"></canvas>
                <script>
                    window.os = {
                        chart: {
                            labels: <?= json_encode($labels) ?>,
                            data: <?= json_encode($data) ?>
                        }
                    };
                </script>
            </div>
        </div>
    </div>
</div>
<?php $this->end() ?>
