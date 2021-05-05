<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%biaya_tindakan}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%pasien}}`
 * - `{{%pegawai}}`
 * - `{{%tindakan}}`
 */
class m210504_220141_create_biaya_tindakan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%biaya_tindakan}}', [
            'id' => $this->primaryKey(),
            'pasien_id' => $this->integer(10),
            'pegawai_id' => $this->integer(10),
            'tindakan_id' => $this->integer(10),
            'total_harga' => $this->integer(15)->notNull(),
            'status' => $this->boolean()->defaultValue(0),
            'tanggal_periksa' => $this->date()->notNull(),
        ]);

        // creates index for column `pasien_id`
        $this->createIndex(
            '{{%idx-biaya_tindakan-pasien_id}}',
            '{{%biaya_tindakan}}',
            'pasien_id'
        );

        // add foreign key for table `{{%pasien}}`
        $this->addForeignKey(
            '{{%fk-biaya_tindakan-pasien_id}}',
            '{{%biaya_tindakan}}',
            'pasien_id',
            '{{%pasien}}',
            'id',
            'CASCADE'
        );

        // creates index for column `pegawai_id`
        $this->createIndex(
            '{{%idx-biaya_tindakan-pegawai_id}}',
            '{{%biaya_tindakan}}',
            'pegawai_id'
        );

        // add foreign key for table `{{%pegawai}}`
        $this->addForeignKey(
            '{{%fk-biaya_tindakan-pegawai_id}}',
            '{{%biaya_tindakan}}',
            'pegawai_id',
            '{{%pegawai}}',
            'id',
            'CASCADE'
        );

        // creates index for column `tindakan_id`
        $this->createIndex(
            '{{%idx-biaya_tindakan-tindakan_id}}',
            '{{%biaya_tindakan}}',
            'tindakan_id'
        );

        // add foreign key for table `{{%tindakan}}`
        $this->addForeignKey(
            '{{%fk-biaya_tindakan-tindakan_id}}',
            '{{%biaya_tindakan}}',
            'tindakan_id',
            '{{%tindakan}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%pasien}}`
        $this->dropForeignKey(
            '{{%fk-biaya_tindakan-pasien_id}}',
            '{{%biaya_tindakan}}'
        );

        // drops index for column `pasien_id`
        $this->dropIndex(
            '{{%idx-biaya_tindakan-pasien_id}}',
            '{{%biaya_tindakan}}'
        );

        // drops foreign key for table `{{%pegawai}}`
        $this->dropForeignKey(
            '{{%fk-biaya_tindakan-pegawai_id}}',
            '{{%biaya_tindakan}}'
        );

        // drops index for column `pegawai_id`
        $this->dropIndex(
            '{{%idx-biaya_tindakan-pegawai_id}}',
            '{{%biaya_tindakan}}'
        );

        // drops foreign key for table `{{%tindakan}}`
        $this->dropForeignKey(
            '{{%fk-biaya_tindakan-tindakan_id}}',
            '{{%biaya_tindakan}}'
        );

        // drops index for column `tindakan_id`
        $this->dropIndex(
            '{{%idx-biaya_tindakan-tindakan_id}}',
            '{{%biaya_tindakan}}'
        );

        $this->dropTable('{{%biaya_tindakan}}');
    }
}
