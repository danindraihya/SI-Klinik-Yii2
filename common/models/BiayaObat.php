<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "biaya_obat".
 *
 * @property int $id
 * @property int|null $obat_id
 * @property int|null $pasien_id
 * @property int|null $jumlah
 * @property int $total_harga
 * @property int|null $status
 * @property string $tanggal_periksa
 *
 * @property Obat $obat
 * @property Pasien $pasien
 */
class BiayaObat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'biaya_obat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['obat_id', 'pasien_id', 'jumlah', 'total_harga', 'status'], 'integer'],
            [['total_harga', 'tanggal_periksa'], 'required'],
            [['tanggal_periksa'], 'safe'],
            [['obat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Obat::className(), 'targetAttribute' => ['obat_id' => 'id']],
            [['pasien_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pasien::className(), 'targetAttribute' => ['pasien_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'obat_id' => 'Obat ID',
            'pasien_id' => 'Pasien ID',
            'jumlah' => 'Jumlah',
            'total_harga' => 'Total Harga',
            'status' => 'Status',
            'tanggal_periksa' => 'Tanggal Periksa',
        ];
    }

    /**
     * Gets query for [[Obat]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ObatQuery
     */
    public function getObat()
    {
        return $this->hasOne(Obat::className(), ['id' => 'obat_id']);
    }

    /**
     * Gets query for [[Pasien]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\PasienQuery
     */
    public function getPasien()
    {
        return $this->hasOne(Pasien::className(), ['id' => 'pasien_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\BiayaObatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\BiayaObatQuery(get_called_class());
    }
}
