<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%biaya_obat}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%obat}}`
 * - `{{%pasien}}`
 */
class m210504_220209_create_biaya_obat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%biaya_obat}}', [
            'id' => $this->primaryKey(),
            'obat_id' => $this->integer(10),
            'pasien_id' => $this->integer(10),
            'jumlah' => $this->integer(10),
            'total_harga' => $this->integer(15)->notNull(),
            'status' => $this->boolean()->defaultValue(0),
            'tanggal_periksa' => $this->date()->notNull(),
        ]);

        // creates index for column `obat_id`
        $this->createIndex(
            '{{%idx-biaya_obat-obat_id}}',
            '{{%biaya_obat}}',
            'obat_id'
        );

        // add foreign key for table `{{%obat}}`
        $this->addForeignKey(
            '{{%fk-biaya_obat-obat_id}}',
            '{{%biaya_obat}}',
            'obat_id',
            '{{%obat}}',
            'id',
            'CASCADE'
        );

        // creates index for column `pasien_id`
        $this->createIndex(
            '{{%idx-biaya_obat-pasien_id}}',
            '{{%biaya_obat}}',
            'pasien_id'
        );

        // add foreign key for table `{{%pasien}}`
        $this->addForeignKey(
            '{{%fk-biaya_obat-pasien_id}}',
            '{{%biaya_obat}}',
            'pasien_id',
            '{{%pasien}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%obat}}`
        $this->dropForeignKey(
            '{{%fk-biaya_obat-obat_id}}',
            '{{%biaya_obat}}'
        );

        // drops index for column `obat_id`
        $this->dropIndex(
            '{{%idx-biaya_obat-obat_id}}',
            '{{%biaya_obat}}'
        );

        // drops foreign key for table `{{%pasien}}`
        $this->dropForeignKey(
            '{{%fk-biaya_obat-pasien_id}}',
            '{{%biaya_obat}}'
        );

        // drops index for column `pasien_id`
        $this->dropIndex(
            '{{%idx-biaya_obat-pasien_id}}',
            '{{%biaya_obat}}'
        );

        $this->dropTable('{{%biaya_obat}}');
    }
}
