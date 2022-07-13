<?php 

namespace rbacUserManager\widgets;

use Yii;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\Widget;

class MenuItems extends Widget
{

    public function run()
    {
        $menuItems = [];

        foreach([
            'userIndex' => Html::a('Пользователи',
                Yii::$app->urlManager->createUrl(['rbacUserManager/user/index', ]),
                ['class' => 'btn btn-link btn-lg btn-block', ]
            ),
            'permissionIndex' => Html::a('Разрешения',
                Yii::$app->urlManager->createUrl(['rbacUserManager/permission/index', ]),
                ['class' => 'btn btn-link btn-lg btn-block', ]
            ),
            'roleIndex' => Html::a('Роли',
                Yii::$app->urlManager->createUrl(['rbacUserManager/role/index', ]),
                ['class' => 'btn btn-link btn-lg btn-block', ]
            ),
            'ruleIndex' => Html::a('Правила',
                Yii::$app->urlManager->createUrl(['rbacUserManager/rule/index', ]),
                ['class' => 'btn btn-link btn-lg btn-block', ]
            ),
        ] as $permission => $item){
            if(Yii::$app->user->can($permission)){
                $menuItems[] = $item;
            }
        }

        return empty($menuItems) ? NULL :Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [[
                'label' => 'Управление доступом',
                'items' => $menuItems,
            ], ],
        ]);
    }

}
