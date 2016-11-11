<?php 

namespace rbacUserManager\widgets;

use Yii;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\Widget;

class UserMenu extends Widget
{

    public function run()
    {
        return Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => Yii::$app->user->isGuest ? [
                ['label' => 'Войти', 'url' => Yii::$app->urlManager->createUrl(['rbacUserManager/auth/login', ]), ],
            ] : [
                [
                    'label' => Yii::$app->user->identity->username,
                    'dropDownOptions' => ['style' => 'background: #000;', ],
                    'items' => [
                        Html::a('Профиль',
                            Yii::$app->urlManager->createUrl(['rbacUserManager/user/view', 'id' => Yii::$app->user->id, ]),
                            ['class' => 'btn btn-link btn-lg btn-block', ]
                        ),
                        '<li>' . Html::beginForm(Yii::$app->urlManager->createUrl(['rbacUserManager/auth/logout']), 'post') .
                        Html::submitButton('Выход', ['class' => 'btn btn-link btn-lg btn-block', ]) .
                        Html::endForm() . '</li>',
                    ],
                ],
            ],
        ]);
    }

}
