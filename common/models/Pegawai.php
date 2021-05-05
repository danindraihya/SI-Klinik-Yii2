<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pegawai".
 *
 * @property int $id
 * @property string $nama
 * @property string $jabatan
 * @property int|null $telepon
 *
 * @property BiayaTindakan[] $biayaTindakans
 */
class Pegawai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pegawai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'jabatan'], 'required'],
            [['telepon'], 'integer'],
            [['nama'], 'string', 'max' => 50],
            [['jabatan'], 'string', 'max' => 20],
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
            'jabatan' => 'Jabatan',
            'telepon' => 'Telepon',
        ];
    }

    /**
     * Gets query for [[BiayaTindakans]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\BiayaTindakanQuery
     */
    public function getBiayaTindakans()
    {
        return $this->hasMany(BiayaTindakan::className(), ['pegawai_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PegawaiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PegawaiQuery(get_called_class());
    }
}
