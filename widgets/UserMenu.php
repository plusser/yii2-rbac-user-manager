<?php 

namespace rbacUserManager\widgets;

use Yii;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\Widget;

class UserMenu extends Widget
{

    public function run()
    {
        return Nav::widget([
            'options' => ['class' => 'navbar-nav dropleft'],
            'items' => Yii::$app->user->isGuest ? [
                ['label' => 'Войти', 'url' => Yii::$app->urlManager->createUrl(['rbacUserManager/auth/login', ]), ],
            ] : [
                [
                    'label' => Yii::$app->user->identity->username,
                    'items' => [
                        Html::a('Профиль',
                            Yii::$app->urlManager->createUrl(['rbacUserManager/user/view', 'id' => Yii::$app->user->id, ]),
                            ['class' => 'btn btn-link btn-lg btn-block', ]
                        ),
                        Html::beginForm(Yii::$app->urlManager->createUrl(['rbacUserManager/auth/logout']), 'post') .
                        Html::submitButton('Выход', ['class' => 'btn btn-link btn-lg btn-block', ]) .
                        Html::endForm(),
                    ],
                ],
            ],
        ]);
    }

}
