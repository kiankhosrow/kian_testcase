<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $message
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $first_name="";
    public $last_name="";
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'required'],
            [['message'], 'string', 'max' => 255],
            ['message','custom_function_validation'],
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function custom_function_validation($attribute, $params)
    {
        $string = $this->message;
        if($string && $string != strip_tags($string)) {
            $this->addError($attribute,'HTML not allow in message');
            return false;
        }
        else{
            return true;
        }

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'message' => 'Message',
        ];
    }
}
