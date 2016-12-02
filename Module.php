<?php 

namespace rbacUserManager;

use Yii;

class Module extends \yii\base\Module
{

    public $rememberMe = true;
    public $rememberMeDaysCount = 30;
    public $paginationPageSize = 10;
    public $mailerViewPath = '@rbacUserManager/mail';

	public $passwordMinLength = 6;

	public $userAdditionalForm = NULL;
	public $userAdditionalView = NULL;
	public $userAdditionalIndex = NULL;

	public function init()
    {
		parent::init();

        if(($app = Yii::$app) instanceof \yii\web\Application){
            $app->getUrlManager()->addRules([
/*	AUTH	*/
				['class' => 'yii\web\UrlRule', 'pattern' => 'user/login', 'route' => $this->id . '/auth/login'],
				['class' => 'yii\web\UrlRule', 'pattern' => 'user/logout', 'route' => $this->id . '/auth/logout'],
				['class' => 'yii\web\UrlRule', 'pattern' => 'user/signup', 'route' => $this->id . '/auth/signup'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'user/request-password-reset', 'route' => $this->id . '/auth/request-password-reset'],
				['class' => 'yii\web\UrlRule', 'pattern' => 'user/reset-password', 'route' => $this->id . '/auth/reset-password'],
/*	USER	*/
                ['class' => 'yii\web\UrlRule', 'pattern' => 'user', 'route' => $this->id . '/user/index'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'user/<id:\d+>', 'route' => $this->id . '/user/view'],
				['class' => 'yii\web\UrlRule', 'pattern' => 'user/update/<id:\d+>', 'route' => $this->id . '/user/update'],
				['class' => 'yii\web\UrlRule', 'pattern' => 'user/delete/<id:\d+>', 'route' => $this->id . '/user/delete'],
/*	PERMISSION	*/
				['class' => 'yii\web\UrlRule', 'pattern' => 'permission', 'route' => $this->id . '/permission/index'],
				['class' => 'yii\web\UrlRule', 'pattern' => 'permission/create', 'route' => $this->id . '/permission/create'],
				['class' => 'yii\web\UrlRule', 'pattern' => 'permission/<id:\w+>', 'route' => $this->id . '/permission/view'],
				['class' => 'yii\web\UrlRule', 'pattern' => 'permission/update/<id:\w+>', 'route' => $this->id . '/permission/update'],
				['class' => 'yii\web\UrlRule', 'pattern' => 'permission/delete/<id:\w+>', 'route' => $this->id . '/permission/delete'],
/*	ROLE	*/
				['class' => 'yii\web\UrlRule', 'pattern' => 'role', 'route' => $this->id . '/role/index'],
				['class' => 'yii\web\UrlRule', 'pattern' => 'role/create', 'route' => $this->id . '/role/create'],
				['class' => 'yii\web\UrlRule', 'pattern' => 'role/<id:\w+>', 'route' => $this->id . '/role/view'],
				['class' => 'yii\web\UrlRule', 'pattern' => 'role/update/<id:\w+>', 'route' => $this->id . '/role/update'],
				['class' => 'yii\web\UrlRule', 'pattern' => 'role/delete/<id:\w+>', 'route' => $this->id . '/role/delete'],
/*	RULE	*/
                ['class' => 'yii\web\UrlRule', 'pattern' => 'rule', 'route' => $this->id . '/rule/index'],
            ], false);

			$app->user->loginUrl = [$this->id . '/auth/login'];
        }

		if($app instanceof yii\console\Application){
			$app->controllerMap['rbac-user-manager'] = 'rbacUserManager\commands\RbacUserManagerController';
		}
    }

}
