<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pasien}}`.
 */
class m210504_220055_create_pasien_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pasien}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string(255)->notNull(),
            'umur' => $this->integer(5)->notNull(),
            'telepon' => $this->integer(12)->notNull(),
            'status' => $this->boolean()->defaultValue(0),
            'tanggal_periksa' => $this->date()->defaultValue(date('Y-m-d'))
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pasien}}');
    }
}
