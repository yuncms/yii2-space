<?php

namespace yuncms\space\migrations;

use yii\db\Migration;

class M161108091056Create_user_visit_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        /**
         * 用户访问历史表
         */
        $this->createTable('{{%visit}}', [
            'id' => $this->primaryKey(11)->unsigned()->comment('ID'),
            'user_id' => $this->integer()->unsigned()->notNull()->comment('User ID'),
            'source_id' => $this->integer()->unsigned()->notNull()->comment('Source User ID'),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('Created At'),
        ], $tableOptions);
        $this->createIndex('visit_source_id_user_id_index', '{{%visit}}', ['user_id', 'source_id']);
        $this->addForeignKey('{{%visit_fk_1}}', '{{%visit}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%visit_fk_2}}', '{{%visit}}', 'source_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropTable('{{%visit}}');
    }
}
