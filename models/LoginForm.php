<?php 

namespace rbacUserManager\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe;

    protected $_user;

    public function __construct()
    {
        $this->rememberMe = Yii::$app->controller->module->rememberMe;
    }

    public function rules()
    {
        return [
            [['username', 'password', ], 'required', ],
            ['rememberMe', 'boolean', ],
            ['password', 'validatePassword', ],
        ];
    }

	public function attributeLabels()
    {
        return [
            'username' => 'Логин',
			'password' => 'Пароль',
            'rememberMe' => 'Запомнить на ' . Yii::$app->controller->module->rememberMeDaysCount . ' дней',
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if(!$this->hasErrors()){
            $user = $this->getUser();
            if(!$user OR !$user->validatePassword($this->password)){
                $this->addError($attribute, 'Неверный логин или пароль.');
            }
        }
    }

    public function login()
    {
        return $this->validate() ? Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * Yii::$app->controller->module->rememberMeDaysCount : 0) : false;
    }

    protected function getUser()
    {
        return $this->_user = (is_null($this->_user) ? User::findByUsername($this->username) : $this->_user);
    }

}
