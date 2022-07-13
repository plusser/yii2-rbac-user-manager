<?php 

namespace rbacUserManager\models;

use yii\base\Model;
use yii\base\InvalidArgumentException;

class ResetPasswordForm extends Model
{
    public $password;

    protected $_user;

    public function __construct($token, $config = [])
    {
        if(empty($token) OR !is_string($token)){
            throw new InvalidArgumentException('Токен восстановления пароля не может быть пустым.');
        }

        if(!is_object($this->_user = User::findByPasswordResetToken($token))){
            throw new InvalidArgumentException('Неверный токен восстановления пароля.');
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

	public function attributeLabels()
    {
        return [
			'password' => 'Новый пароль',
        ];
    }

    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }

}
