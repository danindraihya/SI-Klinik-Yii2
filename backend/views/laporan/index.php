<?php
/* @var $this yii\web\View */
use common\models\Obat;

$namaObat = [];
$jumlah = [];

foreach($jumlahObat as $obat) {
    $data = Obat::find()
        ->where(['id' => $obat['obat_id']])
        ->all();
    
    array_push($namaObat, $data[0]['nama']);
    array_push($jumlah, $obat['jumlah']);    
}

$namaObat = json_encode($namaObat);
$jumlah = json_encode($jumlah);


?>
<h1>Data Penjualan Obat</h1>


<canvas id="obat" width="400" height="100"></canvas>


<h1>Data Banyaknya Pasien</h1>

<canvas id="pasien" width="400" height="100"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>




<script>
var ctx = document.getElementById('obat').getContext('2d');
var obat = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= $namaObat ?>,
        datasets: [{
            label: 'Jumlah obat',
            data: <?= $jumlah ?>,
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