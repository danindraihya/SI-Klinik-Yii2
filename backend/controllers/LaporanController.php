<?php

namespace backend\controllers;
use common\models\Pasien;
use common\models\Obat;

class LaporanController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $listDate = [];
        $listPasien = [];
        $listObat = [];

        for($i = 0; $i < 10; $i++) {
            $date = date('Y-m-d',strtotime("-". $i ." days"));
            array_push($listDate, $date);
        }

        foreach($listDate as $date) {
            $data = Pasien::find()
                ->where(['tanggal_periksa' => $date])
                ->count();
            
                array_push($listPasien, $data);
        }

        $dataObat = Obat::find()->all();
        $biayaObat = (new \yii\db\Query())
            ->select(['obat_id','sum(jumlah) as jumlah'])
            ->from('biaya_obat')
            ->where(['status' => 1])
            ->groupBy(['obat_id'])
            ->all();

        return $this->render('index', [
            'listDate' => json_encode($listDate),
            'listPasien' => json_encode($listPasien),
            'jumlahObat' => $biayaObat,
            'dataObat' => json_encode($dataObat)
        ]);
    }

}
