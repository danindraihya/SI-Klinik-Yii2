<?php
/* @var $this yii\web\View */
?>
<h1>Pembayaran</h1>

<div>
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
                
                foreach($data as $pasien) {

                    $antrianPasien = (new \yii\db\Query())
                        ->from('pasien')
                        ->where(['id' => $pasien['pasien_id']])
                        ->all();
                    ?>
                    <tr>
                        <th scope="row"><?= $antrianPasien[0]['id']; ?></th>
                        <td><?= $antrianPasien[0]['nama']; ?></td>
                        <td><?= $antrianPasien[0]['umur']; ?></td>
                        <td><?= $antrianPasien[0]['telepon']; ?></td>
                        <td>Menunggu Pembayaran</td>
                        <td><a href="/informasi/update?idPasien=<?= $antrianPasien[0]['id']; ?>&idPegawai=<?= $pasien['pegawai_id']; ?>" title="Update" aria-label="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a> </td>
                    <tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
</div>