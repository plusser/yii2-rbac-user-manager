<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap4\Tabs;

$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->title = 'Пользователь ' . ($this->params['breadcrumbs'][] = $model->username);

$attributes = [
    'id',
    'username',
    [
        'attribute' => 'email',
        'content'   => Html::a($model->email, 'mailto:' . $model->email),
    ],
    [
        'attribute' => 'status',
        'value'     => $model->status == $model::STATUS_ACTIVE ? 'Да' : 'Нет',
    ],
    [
        'attribute' => 'created_at',
        'value'     => date('d-m-Y H:i:s', $model->created_at),
    ],
    [
        'attribute' => 'updated_at',
        'value'     => date('d-m-Y H:i:s', $model->updated_at),
    ],
];

if(is_array($userAdditionalView = Yii::$app->controller->module->userAdditionalView)){

    $className = $userAdditionalView[0];
    $method = $userAdditionalView[1];

    foreach($className::$method($model) as $item){
        $attributes[] = $item;
    }
}

$attributes[] = [
        'format'    => 'raw',
        'label'     => 'Роли и разрешения',
        'attribute' => 'roleList',
        'value'     => Tabs::widget([
        'items'     => [
            [
                'label'     => 'Роли (' . count($R = $model->roleList) . ')',
                'content'   => $this->render('_roleListView', ['roleList' => $R]),
            ],
            [
                'label'     => 'Разрешения (' . count($P = $model->permissionList) . ')',
                'content'   => $this->render('_permissionListView', ['permissionList' =>  $P]),
                'active'    => true,
            ],
        ],
    ]),
];

?>

<div class="user-view">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php if(Yii::$app->user->can('userUpdate') OR Yii::$app->user->can('userProfileOwner', ['userId' => $model->id])){echo Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-success']);} ?>
        <?php if(Yii::$app->user->can('userDelete')){echo Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm'   => 'Точно удалить?',
                'method'    => 'post',
            ],
        ]);} ?>
    </p>

    <?php echo DetailView::widget([
        'model'         => $model,
        'attributes'    => $attributes,
    ]); ?>

</div>
