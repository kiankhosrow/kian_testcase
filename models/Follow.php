<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "follow".
 *
 * @property int $id
 * @property int $user_id
 * @property int $touser_id
 */
class Follow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'follow';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'touser_id'], 'required'],
            [['user_id', 'touser_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'touser_id' => 'Touser ID',
        ];
    }
}
