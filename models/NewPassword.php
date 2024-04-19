<?php

namespace app\models;

use app\models\User;
use PHPUnit\Framework\MockObject\Builder\Identity;
use Yii;
use yii\base\Model;

/**
 * Password reset form
 */
class NewPassword extends Model
{
    public $currentPassword;
    public $newPassword;
    public $newPasswordRepeat;


    private $_user = false ;
    /**
     * @var User
     */
    /**
     * @param User $user
     * @param array $config
     */
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'newPasswordRepeat'], 'required'],
            ['currentPassword', 'validatePassword'],
            ['newPassword', 'validateNewPassword'],
            ['newPassword', 'match', 'pattern' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", 'message' => 'Пароль должен содержать 1 большую латинскую букву, 1 маленькую, 1 спецсимвол, 1 цифру и должен содержать не менее 8 символов'],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Пароли должны совпадать'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'newPassword' => 'Новый пароль',
            'newPasswordRepeat' => 'Повторите пароль',
            'currentPassword' => 'Старый пароль',
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

    public function validateNewPassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || $user->validatePassword($this->newPassword)) {
                $this->addError($attribute, 'Пароль не должен совпадать со старым.');
            }
        }

    }

    /**
     * @return boolean
     */
    public function changePassword()
    {
        if ($this->validate()) {
            $this->_user->password = Yii::$app->security->generatePasswordHash($this->newPassword);
            $this->_user->save(false);
            Yii::$app->session->setFlash('info', 'q123');
            return true;
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