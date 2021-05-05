<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "obat".
 *
 * @property int $id
 * @property string $nama
 * @property int $harga
 *
 * @property BiayaObat[] $biayaObats
 */
class Obat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'harga'], 'required'],
            [['harga'], 'integer'],
            [['nama'], 'string', 'max' => 100],
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
            'harga' => 'Harga',
        ];
    }

    /**
     * Gets query for [[BiayaObats]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\BiayaObatQuery
     */
    public function getBiayaObats()
    {
        return $this->hasMany(BiayaObat::className(), ['obat_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ObatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ObatQuery(get_called_class());
    }
}
