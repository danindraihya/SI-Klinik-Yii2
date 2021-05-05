<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pasien".
 *
 * @property int $id
 * @property string $nama
 * @property int $umur
 * @property int $telepon
 * @property int|null $status
 *
 * @property BiayaObat[] $biayaObats
 * @property BiayaTindakan[] $biayaTindakans
 */
class Pasien extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pasien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'umur', 'telepon'], 'required'],
            [['umur', 'telepon', 'status'], 'integer'],
            [['nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'umur' => 'Umur',
            'telepon' => 'Telepon',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[BiayaObats]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\BiayaObatQuery
     */
    public function getBiayaObats()
    {
        return $this->hasMany(BiayaObat::className(), ['pasien_id' => 'id']);
    }

    /**
     * Gets query for [[BiayaTindakans]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\BiayaTindakanQuery
     */
    public function getBiayaTindakans()
    {
        return $this->hasMany(BiayaTindakan::className(), ['pasien_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PasienQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PasienQuery(get_called_class());
    }
}
