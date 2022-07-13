<?php 

namespace rbacUserManager\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use crud\actions\IndexAction;
use rbacUserManager\models\RuleSearch;


class RuleController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', ],
                'rules' => [
                    'index' => [
                        'actions' => ['index', ],
                        'allow' => true,
                        'roles' => ['ruleIndex', ],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::class,
                'searchModel' => new RuleSearch,
            ],
        ];
    }

}
