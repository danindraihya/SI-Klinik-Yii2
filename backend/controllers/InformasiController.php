<?php

namespace backend\controllers;

use yii\helpers\Json;
use common\models\Pasien;
use Yii;
use common\models\BiayaObat;
use common\models\BiayaTindakan;
use kartik\mpdf\Pdf;

class InformasiController extends \yii\web\Controller
{

    public function actionIndex()
    {
        $listPasien = [];

        $biayaObat = (new \yii\db\Query())
            ->select(['pasien_id', 'sum(total_harga) as total_harga'])
            ->from('biaya_obat')
            ->where(['status' => 0])
            ->groupBy(['pasien_id'])
            ->all();

        $biayaTindakan = (new \yii\db\Query())
            ->select(['pasien_id', 'sum(total_harga) as total_harga'])
            ->from('biaya_tindakan')
            ->where(['status' => 0])
            ->groupBy(['pasien_id'])
            ->all();

            foreach($biayaObat as $data) {
                array_push($listPasien, $data['pasien_id']);
            }
            
        $pasienBayar = (new \yii\db\Query())
            ->select(['o.pasien_id', 't.pegawai_id', 'sum(o.total_harga) as total_harga_obat', 'sum(t.total_harga) as total_harga_tindakan'])
            ->from(['o' => 'biaya_obat'])
            ->innerJoin(['t' => 'biaya_tindakan'], '`o`.`pasien_id` = `t`.`pasien_id`')
            ->orWhere(['or', ['o.status' => 0], ['t.status' => 0]])
            ->groupBy(['o.pasien_id'])
            ->all();
        
        $pasienSelesai = (new \yii\db\Query())
            ->select(['o.pasien_id', 't.pegawai_id', 'sum(o.total_harga) as total_harga_obat', 'sum(t.total_harga) as total_harga_tindakan'])
            ->from(['o' => 'biaya_obat'])
            ->innerJoin(['t' => 'biaya_tindakan'], '`o`.`pasien_id` = `t`.`pasien_id`')
            ->orWhere(['or', ['o.status' => 1], ['t.status' => 1]])
            ->groupBy(['o.pasien_id'])
            ->all();
        
        
        return $this->render('index', [
            'pasienBayar' => $pasienBayar,
            'pasienSelesai' => $pasienSelesai
        ]);
        
    }

    public function actionUpdate($idPasien, $idPegawai)
    {
        $pasien = (new \yii\db\Query())
            ->from('pasien')
            ->where(['id' => $idPasien])
            ->one();
        
        $pegawai = (new \yii\db\Query())
            ->from('pegawai')
            ->where(['id' => $idPegawai])
            ->one();

        $biayaObat = (new \yii\db\Query())
            ->from('biaya_obat')
            ->where(['pasien_id' => $idPasien, 'status' => 0])
            ->all();

        $biayaTindakan = (new \yii\db\Query())
            ->from('biaya_tindakan')
            ->where(['pasien_id' => $idPasien, 'status' => 0])
            ->all();

        $session = Yii::$app->session;
        $session->open();

        $session->set('pasien', $pasien);
        $session->set('pegawai', $pegawai);
        $session->set('biayaObat', $biayaObat);
        $session->set('biayaTindakan', $biayaTindakan);

        return $this->render('update', [
            'pasien' => $pasien,
            'pegawai' => $pegawai,
            'biayaObat' => $biayaObat,
            'biayaTindakan' => $biayaTindakan
        ]);
    }

    public function actionPembayaran()
    {
        $request = Yii::$app->request;

        $biayaObat = (new \yii\db\Query())
            ->from('biaya_obat')
            ->where(['pasien_id' => $request->post('idPasien')])
            ->all();
        
        foreach($biayaObat as $data) {
            $newData = BiayaObat::find()
                ->where(['id' => $data['id']])
                ->one();
            $newData->status = 1;
            $newData->save();
        }

        $biayaTindakan = (new \yii\db\Query())
            ->from('biaya_tindakan')
            ->where(['pasien_id' => $request->post('idPasien')])
            ->all();
        
        foreach($biayaTindakan as $data) {
            $newData = BiayaTindakan::find()
                ->where(['id' => $data['id']])
                ->one();
            $newData->status = 1;
            $newData->save();
        }

        $session = Yii::$app->session;
        $session->open();

        $session->set('totalHarga', $request->post('totalHarga'));
        $session->set('cash', $request->post('cash'));

        return $this->redirect(['cetak']);
    }

    public function actionCetak()
    {

        $session = Yii::$app->session;
        $session->open();

        $content = $this->renderPartial('print', [
            'pasien' => $session->get('pasien'),
            'pegawai' => $session->get('pegawai'),
            'biayaObat' => $session->get('biayaObat'),
            'biayaTindakan' => $session->get('biayaTindakan'),
            'totalHarga' => $session->get('totalHarga'),
            'cash' => $session->get('cash')
        ]);
 
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'options' => []
 
        ]);

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;

        return $pdf->render();
    }
}
