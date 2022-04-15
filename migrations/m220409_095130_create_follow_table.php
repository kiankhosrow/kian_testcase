<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%follow}}`.
 */
class m220409_095130_create_follow_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%follow}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'touser_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%follow}}');
    }
}
