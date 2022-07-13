<?php 

namespace rbacUserManager\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{

    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            ['username', 'trim', ],
            ['username', 'required', ],
            ['username', 'unique', 'targetClass' => '\rbacUserManager\models\User', 'message' => 'Пользователь с таким логином уже существует.', ],
            ['username', 'string', 'min' => 2, 'max' => 255, ],

            ['email', 'trim', ],
            ['email', 'required'],
            ['email', 'email', ],
            ['email', 'string', 'max' => 255, ],
            ['email', 'unique', 'targetClass' => '\rbacUserManager\models\User', 'message' => 'Пользователь с такой электронной почтой уже существует.', ],

            ['password', 'required', ],
            ['password', 'string', 'min' => is_object($module = Yii::$app->getModule('rbacUserManager')) ? $module->passwordMinLength : 6, ],
        ];
    }

	public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Электронная почта',
			'password' => 'Пароль',
        ];
    }

    public function signup()
    {
		$result = NULL;

        if($this->validate()){
			$user = new User();
			$user->username = $this->username;
			$user->email = $this->email;
			$user->setPassword($this->password);
			$user->generateAuthKey();
			$result = $user->save() ? $user : NULL;
        }

        return $result;
    }

}
