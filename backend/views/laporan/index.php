<?php
/* @var $this yii\web\View */
?>
<h1>Data Banyaknya Pasien</h1>


<canvas id="pasien" width="400" height="100"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
var ctx = document.getElementById('pasien').getContext('2d');
var pasien = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= $listDate ?>,
        datasets: [{
            label: 'Jumlah Pasien',
            data: <?= $listPasien ?>,
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>