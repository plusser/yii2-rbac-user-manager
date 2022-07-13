<?php 

namespace rbacUserManager\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use rbacUserManager\models\LoginForm;
use rbacUserManager\models\PasswordResetRequestForm;
use rbacUserManager\models\ResetPasswordForm;
use rbacUserManager\models\SignupForm;

class AuthController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', ],
                'rules' => [
                    [
                        'actions' => ['signup', ],
                        'allow' => true,
                        'roles' => ['userCreate',],
                    ],
                    [
                        'actions' => ['logout', ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post', ],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        if(!Yii::$app->user->isGuest){
            return $this->goHome();
        }elseif(is_object($model = new LoginForm()) && $model->load(Yii::$app->request->post()) AND $model->login()){
            return $this->goBack();
        }else{
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        if(is_object($model = new SignupForm()) && $model->load(Yii::$app->request->post())){
            if($user = $model->signup()){
                return $this->redirect(['user/update', 'id' => $user->id, ]);
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        if(is_object($model = new PasswordResetRequestForm()) && $model->load(Yii::$app->request->post()) && $model->validate()){
            if($model->sendEmail()){
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту и следуйте инструкциям в письме.');
                return $this->goHome();
            }else{
                Yii::$app->session->setFlash('error', 'Извините, но восстановление пароля временно не работает.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try{
            $model = new ResetPasswordForm($token);
        }catch(InvalidArgumentException $e){
            throw new BadRequestHttpException($e->getMessage());
        }

        if($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()){
            Yii::$app->session->setFlash('success', 'Новый пароль сохранен.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
