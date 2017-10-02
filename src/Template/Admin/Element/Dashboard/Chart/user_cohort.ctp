<div class="card os-number-widget">
    <canvas id="chart-user-cohort" width="400" height="400"></canvas>
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

    window.onload = function() {
        new Chart(
            document.getElementById('chart-user-cohort').getContext('2d'),
            {
                type: 'line',
                data: {
                    datasets: [
                        {
                            data: [<?= $countCitizen ?>, <?= $countPolitician ?>, <?= $countAdmin ?>],
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
</script>
