<?php
/**
 * @var int $citizenCount
 * @var int $politicianCount
 * @var int $adminCount
 */
?>

<div class="card os-number-widget">
    <canvas id="chart-user-role" width="400" height="400"></canvas>
</div>

<script>
    window.chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
    };

    renderRoleChart = function (element) {
        new Chart(
            element.getContext('2d'),
            {
                type: 'doughnut',
                data: {
                    datasets: [
                        {
                            data: [<?= $citizenCount ?>, <?= $politicianCount ?>, <?= $adminCount ?>],
                            backgroundColor: [window.chartColors.green, window.chartColors.blue, window.chartColors.red],
                        }
                    ],
                    labels: ['Citizens', 'Politicians', 'Admins']
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Breakdown by Role'
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            }
        );
    };

    window.onload = function () {
        renderRoleChart(document.getElementById('chart-user-role'))
    };
</script>
