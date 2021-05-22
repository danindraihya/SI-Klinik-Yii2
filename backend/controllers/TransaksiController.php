<?php

namespace backend\controllers;
use common\models\Obat;
use common\models\Pasien;
use common\models\Tindakan;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use common\models\BiayaObat;
use common\models\BiayaTindakan;
use common\models\Pegawai;

class TransaksiController extends \yii\web\Controller
{
    public function actionIndex()
    {

        $antrianPasien = Pasien::find()->where(['status' => 0])->orderBy(['id' => SORT_ASC])->all();
        
        return $this->render('index', ['antrianPasien' => $antrianPasien]);
    }

    public function actionUpdate($id)
    {
        $session = Yii::$app->session;
        $session->open();

        $allTindakan = Tindakan::find()->all();
        $allObat = Obat::find()->all(null);
        $pasien = Pasien::find()->where(['id' => $id])->one();
        $allPegawai = Pegawai::find()->all();
        $biayaObat = BiayaObat::find()
            ->where(['pasien_id' => $id])->all();
        $biayaTindakan = BiayaTindakan::find()
            ->where(['pasien_id' => $id])->all();

            

        foreach($biayaTindakan as $tindakan) {
            $dataTindakan = Tindakan::find()
            ->where(['id' => $tindakan['tindakan_id']])
            ->one();

            $session->set('tindakan', [
                $dataTindakan['id'] => [
                    'id' => $dataTindakan->id,
                    'nama' => $dataTindakan->nama,
                    'biaya' => $dataTindakan->biaya
                ]
            ]);
        }

        return $this->render('update', [
            'allTindakan' => $allTindakan,
            'allObat' => $allObat,
            'pasien' => $pasien,
            'allPegawai' => $allPegawai,
            'biayaObat' => $biayaObat,
            'biayaTindakan' => $biayaTindakan
        ]);
    }

    public function actionTambahTindakan($id)
    {
        $session = Yii::$app->session;
        $session->open();

        $tindakan = Tindakan::find()->where(['id' => $id])->one();

        if($session->get('tindakan')) {
            $data = $session->get('tindakan'); 
            $data[strval($id)] = [
                'id' => $tindakan->id,
                'nama' => $tindakan->nama,
                'biaya' => $tindakan->biaya
            ];
            $session->set('tindakan', $data);
        } else {
            $session->set('tindakan', [
                $id => [
                    'id' => $tindakan->id,
                    'nama' => $tindakan->nama,
                    'biaya' => $tindakan->biaya
                ]
            ]);
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $session->get('tindakan');
    }

    public function actionHapusTindakan($id)
    {
        $session = Yii::$app->session;
        $session->open();

        $data = $session->get('tindakan');
        unset($data[strval($id)]);
        $session->set('tindakan', $data);

        if($session->get('tindakan') == []) {
            $session->remove('tindakan');
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $session->get('tindakan');
    }

    public function actionTambahObat($id, $jumlah)
    {
        $session = Yii::$app->session;
        $session->open();

        $obat = Obat::find()->where(['id' => $id])->one();

        if($session->get('obat')) {
            $data = $session->get('obat'); 
            $data[strval($id)] = [
                'id' => $obat->id,
                'nama' => $obat->nama,
                'jumlah' => $jumlah,
                'harga' => $obat->harga
            ];
            $session->set('obat', $data);
        } else {
            $session->set('obat', [
                $id => [
                    'id' => $obat->id,
                    'nama' => $obat->nama,
                    'jumlah' => $jumlah,
                    'harga' => $obat->harga
                ]
            ]);
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $session->get('obat');
    }

    public function actionHapusObat($id)
    {
        $session = Yii::$app->session;
        $session->open();

        $data = $session->get('obat');
        unset($data[strval($id)]);
        $session->set('obat', $data);

        if($session->get('obat') == []) {
            $session->remove('obat');
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $session->get('obat');
    }

    public function actionSubmitTransaksi($idPasien, $idPegawai)
    {
        $session = Yii::$app->session;
        $session->open();
        $total_harga = 0;

        $biayaTindakan = BiayaTindakan::deleteAll('pasien_id = ' . $idPasien);

        if($session->get('obat')) {
            
            foreach($session->get('obat') as $obat) {
                $biayaObat = new BiayaObat();

                $biayaObat->obat_id = $obat['id'];
                $biayaObat->pasien_id = $idPasien;
                $biayaObat->jumlah = $obat['jumlah'];
                $biayaObat->total_harga = $obat['harga'] * $obat['jumlah'];
                $biayaObat->tanggal_periksa = date('Y-m-d');
                $biayaObat->save();
            }

            $session->remove('obat');
        }

        if($session->get('tindakan')) {
            foreach($session->get('tindakan') as $tindakan) {
                $biayaTindakan = new BiayaTindakan();

                $biayaTindakan->pasien_id = $idPasien;
                $biayaTindakan->pegawai_id = $idPegawai;
                $biayaTindakan->tindakan_id = $tindakan['id'];
                $biayaTindakan->total_harga = $tindakan['biaya'];
                $biayaTindakan->tanggal_periksa = date('Y-m-d');
                $biayaTindakan->save();
            }

            $session->remove('tindakan');
        }

        $session->close();

        $pasien = Pasien::find()
            ->where(['id' => $idPasien])
            ->one();

        return $this->redirect(['informasi/index', 
            'idPasien' => $idPasien
        ]);

    }

}
