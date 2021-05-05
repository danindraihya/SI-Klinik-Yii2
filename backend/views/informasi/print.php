<html>
<div>
    <h3>Nama Pasien : </h3><h4><?= $pasien['nama'] ?></h4>

    <h3>Nama Pegawai :</h3><h4><?= $pegawai['nama'] ?></h4>

    <hr>

    <h4>Tindakan</h4>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tindakan</th>
                <th scope="col">Biaya</th>
            </tr>
        </thead>
        <tbody>
    
            <?php
                $hargaTindakan = 0;

                foreach($biayaTindakan as $data) {
                    

                    $tindakan = (new \yii\db\Query())
                        ->from('tindakan')
                        ->where(['id' => $data['tindakan_id']])
                        ->one();

                        $hargaTindakan += $tindakan['biaya'];

                    ?>
                    <tr>
                        <th scope="row"><?= $tindakan['id'] ?></th>
                        <td><?= $tindakan['nama'] ?></td>
                        <td><?= $tindakan['biaya'] ?></td>
                    </tr>
                    <?php
                }
            ?>
    
        </tbody>
    </table>

    <hr>

    <h4>Obat</h4>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Obat</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $hargaObat = 0;

                foreach($biayaObat as $data) {
                    $obat = (new \yii\db\Query())
                        ->from('obat')
                        ->where(['id' => $data['obat_id']])
                        ->one();

                        $hargaObat += $obat['harga'] * $data['jumlah'];
                    
                    ?>
                    <tr>
                        <th scope="row"><?= $obat['id'] ?></th>
                        <td><?= $obat['nama'] ?></td>
                        <td><?= $data['jumlah'] ?></td>
                        <td><?= $obat['harga'] * $data['jumlah'] ?></td>
                    </tr>
                    <?php
                }
            ?>

        </tbody>
    </table>

    <h3>Total Harga : <?= $totalHarga ?></h3>
    <h3>Cash : <?= $cash ?></h3>
    <h3>Kembali : <?= $cash - $totalHarga ?></h3>

       

</div>

</html>