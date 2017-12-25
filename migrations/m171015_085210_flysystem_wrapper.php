<?php

use yii\db\Migration;

/**
 * Class m171015_085210_filemanager
 * php yii migrate/up --migrationPath=@education/runtime/tmp-extensions/yii2-file-manager/migrations
 */
class m171015_085210_flysystem_wrapper extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey(),
            'file_name' => $this->string(255)->notNull(),
            'path' => $this->string(255)->notNull()->unique(),
            'size' => $this->integer()->notNull(),
            'mime_type' => $this->string(25)->notNull(),
            'context' => $this->string(100)->null(),
            'version' => $this->integer()->null(),
            'hash' => $this->string(64)->notNull()->unique(),
            'created_time' => $this->timestamp(),
            'created_user_id' => $this->integer(),
            'modified_time' => $this->timestamp(),
            'modified_user_id' => $this->integer(),
            'deleted_time' => $this->timestamp(),
        ], $tableOptions);

        $this->createTable('{{%file_metadata}}', [
            'id' => $this->primaryKey(),
            'file_id' => $this->integer()->notNull(),
            'metadata' => $this->string(255)->notNull(),
            'value' => $this->string(255)->notNull(),
            'created_time' => $this->timestamp(),
            'created_user_id' => $this->integer(),
            'modified_time' => $this->timestamp(),
            'modified_user_id' => $this->integer(),
            'deleted_time' => $this->timestamp(),
        ], $tableOptions);


        $this->addForeignKey('fk_file_created_user_id', '{{%file}}', 'created_user_id', '{{%user}}', 'id');
        $this->addForeignKey('fk_file_modified_user_id', '{{%file}}', 'modified_user_id', '{{%user}}', 'id');

        $this->addForeignKey('fk_file_metadata_created_user_id', '{{%file_metadata}}', 'created_user_id', '{{%user}}', 'id');
        $this->addForeignKey('fk_file_metadata_modified_user_id', '{{%file_metadata}}', 'modified_user_id', '{{%user}}', 'id');

        $this->addForeignKey('fk_file_metadata', '{{%file_metadata}}', 'file_id', '{{%file}}', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%file_metadata}}');
        $this->dropTable('{{%file}}');
    }
}
