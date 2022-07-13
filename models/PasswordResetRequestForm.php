<?php

namespace rbacUserManager\models;

use Yii;
use yii\base\Model;

class PasswordResetRequestForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass'   => User::class,
                'filter'        => ['status' => User::STATUS_ACTIVE],
                'message'       => 'Пользователя с такой электронной почтой не существует.',
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта',
        ];
    }

    public function sendEmail()
    {

        $result = false;

        if(is_object($user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]))){
            if(!User::isPasswordResetTokenValid($user->password_reset_token)){
                $user->generatePasswordResetToken();
                if($user->save()){
                    if(!empty(Yii::$app->controller->module->mailerViewPath)){
                        Yii::$app->mailer->viewPath = Yii::$app->controller->module->mailerViewPath;
                    }
                    $result = Yii::$app->mailer->compose(
                        ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text', ],
                        ['user' => $user, ]
                    )->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot', ])
                    ->setTo($this->email)
                    ->setSubject('Восстановление пароля для ' . Yii::$app->name)
                    ->send();
                }
            }
        }

        return $result;
    }
}
