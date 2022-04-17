<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m220409_063155_create_user_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
 
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
 
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'first_name' => $this->string()->null(),
            'last_name' => $this->string()->null(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->null(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->insert('user', [
            'username' => 'admin@admin.com',
            'first_name'=>'admin',
            'last_name'=>'admin',
            'auth_key'=>'admin',
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
            'email'=>'admin@admin.com',
            'created_at'=>'2022-04-16 14:01:51',
            'updated_at'=>'2022-04-16 14:01:51',

        ]);
    }
 
    public function down()
    {
        $this->dropTable('user');
    }
}
