<?php 

namespace rbacUserManager\controllers;

use Yii;
use crud\controllers\CRUDController;
use rbacUserManager\models\User;
use rbacUserManager\models\UserSearch;

class UserController extends CRUDController
{

    public function actions()
    {
        $result = parent::actions();

        unset($result['create']);

        return $result;
    }

    public function behaviors()
    {
        $result = parent::behaviors();

        $result['access']['only'] = ['index', 'view', 'update', 'delete', ];
        unset($result['access']['rules']['create']);

        unset($result['access']['rules']['view']['roles']);
        $result['access']['rules']['view']['matchCallback'] = function($rule, $action){
            return Yii::$app->user->can('userView') || Yii::$app->user->can('userProfileOwner', ['userId' => Yii::$app->request->getQueryParam('id'), ]);
        };

        unset($result['access']['rules']['update']['roles']);
        $result['access']['rules']['update']['matchCallback'] = function($rule, $action){
            return Yii::$app->user->can('userUpdate') || Yii::$app->user->can('userProfileOwner', ['userId' => Yii::$app->request->getQueryParam('id'), ]);
        };

        return $result;
    }

    public function getModelClass()
    {
        return User::class;
    }

    public function getModelSearch()
    {
        return new UserSearch;
    }

    public function getPermissionPrefix()
    {
        return 'user';
    }

}
