<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "biaya_tindakan".
 *
 * @property int $id
 * @property int|null $pasien_id
 * @property int|null $pegawai_id
 * @property int|null $tindakan_id
 * @property int $total_harga
 * @property int|null $status
 * @property string $tanggal_periksa
 *
 * @property Pasien $pasien
 * @property Pegawai $pegawai
 * @property Tindakan $tindakan
 */
class BiayaTindakan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'biaya_tindakan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pasien_id', 'pegawai_id', 'tindakan_id', 'total_harga', 'status'], 'integer'],
            [['total_harga', 'tanggal_periksa'], 'required'],
            [['tanggal_periksa'], 'safe'],
            [['pasien_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pasien::className(), 'targetAttribute' => ['pasien_id' => 'id']],
            [['pegawai_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['pegawai_id' => 'id']],
            [['tindakan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tindakan::className(), 'targetAttribute' => ['tindakan_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pasien_id' => 'Pasien ID',
            'pegawai_id' => 'Pegawai ID',
            'tindakan_id' => 'Tindakan ID',
            'total_harga' => 'Total Harga',
            'status' => 'Status',
            'tanggal_periksa' => 'Tanggal Periksa',
        ];
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
     * Gets query for [[Pegawai]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\PegawaiQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'pegawai_id']);
    }

    /**
     * Gets query for [[Tindakan]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TindakanQuery
     */
    public function getTindakan()
    {
        return $this->hasOne(Tindakan::className(), ['id' => 'tindakan_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\BiayaTindakanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\BiayaTindakanQuery(get_called_class());
    }
}
