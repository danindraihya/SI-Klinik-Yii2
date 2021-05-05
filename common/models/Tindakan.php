<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tindakan".
 *
 * @property int $id
 * @property string $nama
 * @property int $biaya
 *
 * @property BiayaTindakan[] $biayaTindakans
 */
class Tindakan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tindakan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'biaya'], 'required'],
            [['biaya'], 'integer'],
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
            'biaya' => 'Biaya',
        ];
    }

    /**
     * Gets query for [[BiayaTindakans]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\BiayaTindakanQuery
     */
    public function getBiayaTindakans()
    {
        return $this->hasMany(BiayaTindakan::className(), ['tindakan_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\TindakanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TindakanQuery(get_called_class());
    }
}
