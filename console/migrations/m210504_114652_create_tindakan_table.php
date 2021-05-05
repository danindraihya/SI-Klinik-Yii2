<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tindakan}}`.
 */
class m210504_114652_create_tindakan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tindakan}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string(100)->notNull(),
            'biaya' => $this->integer(10)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tindakan}}');
    }
}
