<?php 

namespace rbacUserManager\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use rbacUserManager\models\User;
use rbacUserManager\components\ActionIndexTrait;
use rbacUserManager\components\ActionViewTrait;
use rbacUserManager\components\ActionDeleteTrait;
use rbacUserManager\components\ActionCreateUpdateSaveMethodTrait;

class UserController extends Controller
{

    use ActionIndexTrait;
    use ActionViewTrait;
    use ActionDeleteTrait;
    use ActionCreateUpdateSaveMethodTrait;

	public function behaviors()
    {
        return [
			'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update', 'delete', ],
                'rules' => [
                    [
                        'actions' => ['index', ],
                        'allow' => true,
                        'roles' => ['userIndex', ],
                    ],
                    [
                        'actions' => ['view', ],
                        'allow' => true,
						'matchCallback' => function($rule, $action){
							return Yii::$app->user->can('userView') OR Yii::$app->user->can('userProfileOwner', ['userId' => Yii::$app->request->getQueryParam('id'), ]);
						},
                    ],
                    [
                        'actions' => ['update', ],
                        'allow' => true,
						'matchCallback' => function($rule, $action){
							return Yii::$app->user->can('userUpdate') OR Yii::$app->user->can('userProfileOwner', ['userId' => Yii::$app->request->getQueryParam('id'), ]);
						},
                    ],
                    [
                        'actions' => ['delete', ],
                        'allow' => true,
                        'roles' => ['userDelete', ],
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

    protected function getDataProvider()
    {
        return new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => [
                'pageSize' => $this->module->paginationPageSize,
            ],
        ]);
    }

    public function actionUpdate($id)
    {
		return $this->save($this->findModel($id), 'update');
    }

    protected function findModel($id)
    {
        if(is_null($model = User::findOne($id))){
			throw new NotFoundHttpException('Пользователя с ID ' . $id . ' не существует.');
        }

		return $model;
    }

}
