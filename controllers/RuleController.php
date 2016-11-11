<?php 

namespace rbacUserManager\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use rbacUserManager\components\ActionIndexTrait;
use rbacUserManager\components\PermissionRoleProviderTrait;

class RuleController extends Controller
{

    use ActionIndexTrait;
    use PermissionRoleProviderTrait;

	public function behaviors()
    {
        return [
			'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', ],
                'rules' => [
                    [
                        'actions' => ['index', ],
                        'allow' => true,
                        'roles' => ['ruleIndex', ],
                    ],
                ],
            ],
            
        ];
    }

    protected function getDataList()
    {
		return Yii::$app->authManager->getRules();
    }

}
