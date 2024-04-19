<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $roleId
 * @property string $createAt
 * @property string|null $updateAt
 * @property string $authKey
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $passwordRepeat;
    public $terms;
    
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
            [['name', 'email', 'password', 'passwordRepeat'], 'required'],
            [['createAt', 'updateAt'], 'safe'],
            [['email'], 'email', 'message' => 'Некорректный email'],
            [['email'], 'unique', 'message' => 'Данный email уже занят'],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Значение должно совпадать с паролем'],
            [['name', 'email', 'password', 'authKey'], 'string', 'max' => 255],
            ['terms', 'required', 'requiredValue' => 1, 'message' => 'Примите согласие на обработку персональных данных'],
            ['name', 'match', 'pattern' => "/^[А-ЯЁа-яё]+$/u", 'message' => 'Имя может содержать символы кириллицы'],
            ['password', 'match', 'pattern' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", 'message' => 'Пароль должен содержать 1 большую латинскую букву, 1 маленькую, 1 спецсимвол, 1 цифру и должен содержать не менее 8 символов'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Ваше имя',
            'email' => 'Ваш email',
            'password' => 'Придумайте пароль',
            'passwordRepeat' => 'Повторите пароль',
            'terms' => 'Пользовательское соглашение',
        ];
    }

    public function beforeSave($insert)
{
    if (!parent::beforeSave($insert)) {
        return false;
    }

    if ($insert) {
        $this->authKey = Yii::$app->security->generateRandomString();
        $this->password = Yii::$app->security->generatePasswordHash($this->password);
        $this->roleId = 1;
    }
    return true;
}

    public function getIsAdmin() 
    {
        return $this->roleId == Role::getRoleId('Admin');
    }

    public function getIsOrganizer() 
    {
        return $this->roleId == Role::getRoleId('Organizer');
    }

    public static function findByEmail($email) 
    {
        return self::findOne(['email' => $email]);
    }

    public function validatePassword($password) 
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
}
