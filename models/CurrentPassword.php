<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;


/**
 */
class CurrentPassword extends Model
{
    public $currentPassword;
    private $_user = false ;

    /**
     * @var User
     */
    /**
     * @param User $user
     * @param array $config
     * 
     */
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
            [['currentPassword'], 'required'],
            ['currentPassword', 'validatePassword'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'currentPassword' => 'Введите пароль',
        ];
    }

    /**
     * @param string $attribute
     * @param array $params
     */
    
     public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->currentPassword)) {
                $this->addError($attribute, 'Неверный пароль.');
            }
        }

    }

    /**
     * @return boolean
     */

    public function deleteAccount() {
        if ($this->validate()) {
            $user = User::findOne(Yii::$app->user->id);
            Yii::$app->user->logout();
            if ($user->delete()) {
                return true;
            }
        } else {
            return false;
        }
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail(Yii::$app->user->identity->email);
        }
        return $this->_user;
    }
}
