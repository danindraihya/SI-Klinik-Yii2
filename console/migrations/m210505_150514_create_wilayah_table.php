<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%wilayah}}`.
 */
class m210505_150514_create_wilayah_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%wilayah}}', [
            'id' => $this->primaryKey(),
            'lokasi' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%wilayah}}');
    }
}
