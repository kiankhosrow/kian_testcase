<?php

namespace app\models;
use app\models\User;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $user_type 1=Admin 2=Player
 * @property int $created_at
 * @property int $updated_at
 */
class Player extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email'], 'required'],
            [['status', 'user_type', 'created_at', 'updated_at'], 'integer'],
            [['username', 'first_name', 'last_name', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.','filter' => ['!=', 'id', Yii::$app->request->get('id')]],
            ['password_hash', 'required', 'on' => 'create'],
            ['password_hash', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function create()
    {
        if (!$this->validate()) {
            return null;
        }
 
        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        $user->user_type = 2;
        $user->setPassword($this->password_hash);
        $user->generateAuthKey();
        if(!$user->save())
        {
            print_r($user->getErrors());die;
        }
        return $user->save() ? $user : null;
    }
    public function setPassword($password)
    {
        if($password)
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
 
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'user_type' => 'User Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
