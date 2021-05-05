<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Antrian Pasien';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="transaksi-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Nama</th>
            <th scope="col">Umur</th>
            <th scope="col">Telepon</th>
            <th scope="col">Status</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            
                foreach($antrianPasien as $pasien) {
                    ?>
                    <tr>
                        <th scope="row"><?= $pasien['id']; ?></th>
                        <td><?= $pasien['nama']; ?></td>
                        <td><?= $pasien['umur']; ?></td>
                        <td><?= $pasien['telepon']; ?></td>
                        <td>Menunggu</td>
                        <td><a href="/transaksi/update?id=<?= $pasien['id']; ?>" title="Update" aria-label="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a> </td>
                    <tr>
                    <?php
                }
            ?>
        </tbody>
    </table>


</div>

