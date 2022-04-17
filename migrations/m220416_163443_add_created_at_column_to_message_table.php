<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%message}}`.
 */
class m220416_163443_add_created_at_column_to_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%messages}}', 'created_date', $this->dateTime()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%message}}', 'created_date');
    }
}
