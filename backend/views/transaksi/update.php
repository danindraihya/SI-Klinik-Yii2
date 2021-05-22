<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pasien */
use common\models\Tindakan;
use common\models\Obat;

?>
<div class="pasien-update">

    <h1>Layanan Klinik</h1>


        Pilih Tindakan : 
        <select class="form-select tindakan" aria-label="Default select example">
            <option selected>Pilih Tindakan</option>
            <?php 
                foreach($allTindakan as $tindakan){
                ?>
                    <option class='<?= $tindakan['id']; ?>' value=<?= $tindakan['id']; ?>><?= $tindakan['nama'] ?></option>

                <?php
                }
            ?>   
        </select>
        <button id='insertTindakan'>Insert</button>
        <div style='overflow: auto; max-height:170px'>
            <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Biaya</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class='tableTindakan'>
                        <?php 
                        
                            foreach($biayaTindakan as $tindakan) {
                                
                                    $dataTindakan = Tindakan::find()
                                        ->where(['id' => $tindakan['tindakan_id']])
                                        ->one();
                                ?>

                                    <tr>
                                        <td><?= $dataTindakan['id'] ?></td>
                                        <td><?= $dataTindakan['nama'] ?></td>
                                        <td><?= $dataTindakan['biaya'] ?></td>
                                        <td><button data-id='<?= $dataTindakan['id'] ?>' class='hapus-tindakan' >Hapus</button></td>
                                    </tr>

                                <?php
                            }

                        ?>
                    </tbody>
            </table>
        </div>
                

        <hr>

        Pilih Obat : 
        <select class="form-select obat" aria-label="Default select example">
            <option selected>Pilih Obat</option>
            <?php 
                foreach($allObat as $obat){
                ?>
                    <option value=<?= $obat['id'] ?>><?= $obat['nama'] ?></option>

                <?php
                }
            ?>   
        </select>
        <input type="integer" name='jumlah' class='jumlah-obat' value='0'>
        <button id='insertObat'>Insert</button>

        <div style='overflow: auto; max-height:170px'>
            <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class='tableObat'>
                        
                    </tbody>
            </table>
        </div>
        <br>
        <br>

        <form action='/transaksi/submit-transaksi' method="get">
        <input type="hidden" name="idPasien" value=<?= $pasien->id; ?>>
        Pilih Pegawai : 
        <select name='idPegawai' class="form-select obat" aria-label="Default select example">
            <option selected>Pilih Pegawai</option>
                <?php 
                    foreach($allPegawai as $pegawai) {
                        ?>
                            <option value=<?= $pegawai->id ?>><?= $pegawai->nama; ?></option>
                        <?php
                    }                
                ?>
        </select>
            <button type="submit" class='btn btn-primary submit'>Selesai</button> 
        </form>

        
        
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {

        $('#insertTindakan').on('click', function() {
            let markup = '';
            
            let tindakan = $('.tindakan').val();
            let label = $('.' + tindakan).text();
            $('.tindakan').val('');

            $.ajax({
                url: '/transaksi/tambah-tindakan',
                method: 'GET',
                data: {
                    id: tindakan
                },
                success: function(data) {
                    console.log(data);
                    $.each(data, function(index, value) {
                        markup = markup + "<tr><th scope='row'>"+ data[index]['id'] +"</th><td>"+ data[index]['nama'] +"</td><td>" + data[index]['biaya'] + "</td><td><button data-id='"+ data[index]['id'] +"' class='hapus-tindakan' >Hapus</button></td></tr>";
                    });
                    $('.tableTindakan').html(markup);
                }, 
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $(document).on('click', '.hapus-tindakan', function() {
            let markup = '';
            let id = $(this).data('id');
            
            $.ajax({
                url: '/transaksi/hapus-tindakan',
                method: 'GET',
                data: {
                    id: id
                },
                success: function(data) {
                    console.log('test');
                    console.log(data); 
                    $.each(data, function(index, value) {
                        markup = markup + "<tr><th scope='row'>"+ data[index]['id'] +"</th><td>"+ data[index]['nama'] +"</td><td>" + data[index]['biaya'] + "</td><td><button data-id='"+ data[index]['id'] +"' class='hapus-tindakan' >Hapus</button></td></tr>";
                    });
                    $('.tableTindakan').html(markup);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $('#insertObat').on('click', function() {

            let markup = '';
            
            let obat = $('.obat').val();
            let label = $('.' + obat).text();
            $('.obat').val('');

            let jumlah = $('.jumlah-obat').val();
            console.log(typeof(jumlah));

            $.ajax({
                url: '/transaksi/tambah-obat',
                method: 'GET',
                data: {
                    id: obat,
                    jumlah: jumlah
                },
                success: function(data) {
                    console.log(data);
                    $.each(data, function(index, value) {
                        markup = markup + "<tr><th scope='row'>"+ data[index]['id'] +"</th><td>"+ data[index]['nama'] +"</td><td>"+ data[index]['jumlah'] +"</td><td>" + data[index]['harga'] + "</td><td>"+ parseFloat(data[index]['harga']) * parseFloat(data[index]['jumlah']) +"</td><td><button data-id='"+ data[index]['id'] +"' class='hapus-obat' >Hapus</button></td></tr>";
                    });
                    $('.tableObat').html(markup);
                }, 
                error: function(data) {
                    console.log(data);
                }
            });

        });

        $(document).on('click', '.hapus-obat', function() {
            let markup = '';
            let id = $(this).data('id');
            
            $.ajax({
                url: '/transaksi/hapus-obat',
                method: 'GET',
                data: {
                    id: id
                },
                success: function(data) {
                    console.log('test');
                    console.log(data); 
                    $.each(data, function(index, value) {
                        markup = markup + "<tr><th scope='row'>"+ data[index]['id'] +"</th><td>"+ data[index]['nama'] +"</td><td>"+ data[index]['jumlah'] +"</td><td>" + data[index]['harga'] + "</td><td><button data-id='"+ data[index]['id'] +"' class='hapus-obat' >Hapus</button></td></tr>";
                    });
                    $('.tableObat').html(markup);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

    });
</script>
