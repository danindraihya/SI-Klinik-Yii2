<?php

namespace backend\controllers;
use common\models\Pasien;

class LaporanController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $listDate = [];
        $listPasien = [];

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

        return $this->render('index', [
            'listDate' => json_encode($listDate),
            'listPasien' => json_encode($listPasien)
        ]);
    }

}
