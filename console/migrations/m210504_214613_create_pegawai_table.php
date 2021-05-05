<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pegawai}}`.
 */
class m210504_214613_create_pegawai_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pegawai}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string(50)->notNull(),
            'jabatan' => $this->string(20)->notNull(),
            'telepon' => $this->integer(12),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pegawai}}');
    }
}
