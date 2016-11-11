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

class PermissionController extends Controller
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
                        'roles' => ['permissionIndex', ],
                    ],
                    [
                        'actions' => ['create', ],
                        'allow' => true,
                        'roles' => ['permissionCreate', ],
                    ],
                    [
                        'actions' => ['view', ],
                        'allow' => true,
                        'roles' => ['permissionView', ],
                    ],
                    [
                        'actions' => ['update', ],
                        'allow' => true,
                        'roles' => ['permissionUpdate', ],
                    ],
                    [
                        'actions' => ['delete', ],
                        'allow' => true,
                        'roles' => ['permissionDelete', ],
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
		return $this->save(new PermissionRoleForm(Yii::$app->authManager->createPermission(null)), 'create', 'name');
    }

    public function actionUpdate($id)
    {
		return $this->save($this->findModel($id), 'update', 'name');
    }

    protected function getDataList()
    {
		return Yii::$app->authManager->getPermissions();
    }

    protected function findModel($id)
    {
        if(!is_object($model = Yii::$app->authManager->getPermission($id))){
			throw new NotFoundHttpException('Разрешение ' . $id . ' не существует.');
		}

		return new PermissionRoleForm($model);
    }

}
