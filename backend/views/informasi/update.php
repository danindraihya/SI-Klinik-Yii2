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
            <th scope="col">ID</th>
            <th scope="col">Obat</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Total Harga</th>
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
    <br>

        <h3>Total Harga :</h3>
        <input type="number" name="total_pembayaran" class='total-pembayaran' value=<?= $hargaTindakan + $hargaObat ?> disabled>
        <input type="number" name="cash" class='cash'>
        
        <button type="submit" class='bayar'>Bayar</button>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.bayar').on('click', function() {
            let cash = parseInt($('.cash').val());
            let total_pembayaran = parseInt($('.total-pembayaran').val());
            if(cash < total_pembayaran) {
                alert('Uang pembayaran kurang !');
            } else {
                alert('Mencetak Invoice... ');
                $.ajax({
                    url: '/informasi/pembayaran',
                    method: 'post',
                    data: {
                        idPasien: <?= $pasien['id'] ?>,
                        totalHarga: total_pembayaran,
                        cash: cash
                    },
                    success: function(data) {

                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        });
    });
</script>