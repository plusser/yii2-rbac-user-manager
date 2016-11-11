<?php 

namespace rbacUserManager\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use rbacUserManager\models\PermissionRoleForm;
use rbacUserManager\components\ActionIndexTrait;
use rbacUserManager\components\ActionViewTrait;
use rbacUserManager\components\ActionDeleteTrait;
use rbacUserManager\components\ActionCreateUpdateSaveMethodTrait;
use rbacUserManager\components\PermissionRoleProviderTrait;

class RoleController extends Controller
{

    use ActionIndexTrait;
    use ActionViewTrait;
    use ActionDeleteTrait;
    use ActionCreateUpdateSaveMethodTrait;
    use PermissionRoleProviderTrait;

	public function behaviors()
    {
        return [
			'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'view', 'update', 'delete', ],
                'rules' => [
                    [
                        'actions' => ['index', ],
                        'allow' => true,
                        'roles' => ['roleIndex', ],
                    ],
                    [
                        'actions' => ['create', ],
                        'allow' => true,
                        'roles' => ['roleCreate', ],
                    ],
                    [
                        'actions' => ['view', ],
                        'allow' => true,
                        'roles' => ['roleView', ],
                    ],
                    [
                        'actions' => ['update', ],
                        'allow' => true,
                        'roles' => ['roleUpdate', ],
                    ],
                    [
                        'actions' => ['delete', ],
                        'allow' => true,
                        'roles' => ['roleDelete', ],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post', ],
                ],
            ],
        ];
    }

	public function actionCreate()
    {
		return $this->save(new PermissionRoleForm(Yii::$app->authManager->createRole(null)), 'create', 'name');
    }

    public function actionUpdate($id)
    {
		return $this->save($this->findModel($id), 'update', 'name');
    }

    protected function getDataList()
    {
		return Yii::$app->authManager->getRoles();
    }

    protected function findModel($id)
    {
        if(!is_object($model = Yii::$app->authManager->getRole($id))){
			throw new NotFoundHttpException('Роли ' . $id . ' не существует.');
		}

		return new PermissionRoleForm($model);
    }

}
