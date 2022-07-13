<?php

use yii\helpers\Html;
use yii\grid\GridView;
use rbacUserManager\helpers\ViewHelper;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    [
        'attribute'     => 'id',
        'filterOptions' => ['style'	=> 'width: 100px;'],
    ],
    'username',
    [
        'attribute' => 'email',
        'content'   => function($data){return Html::a($data->email, 'mailto:' . $data->email);},
    ],
    [
        'attribute'         => 'status',
        'value'             => function($data){return $data->status == $data::STATUS_ACTIVE ? 'Да' : 'Нет';},
        'headerOptions'     => ['style'	=> 'text-align: center;'],
        'contentOptions'    => ['style'	=> 'text-align: center;'],
        'filterOptions'     => ['style'	=> 'width: 110px;'],
        'filter'            => [
            $searchModel::STATUS_ACTIVE => 'Да',
            $searchModel::STATUS_DELETED => 'Нет',
        ],
    ],
    ViewHelper::GridViewDateTimeColumn($searchModel, 'created_at'),
    ViewHelper::GridViewDateTimeColumn($searchModel, 'updated_at'),
];

if(is_array($userAdditionalIndex = Yii::$app->controller->module->userAdditionalIndex)){

    $className = $userAdditionalIndex[0];
    $method = $userAdditionalIndex[1];

    foreach($className::$method() as $item){
        $columns[] = $item;
    }
}

$actionColumn = $this->context->getActionColumn();
$actionColumn['visibleButtons']['view'] = function($model, $key, $index){
    return Yii::$app->user->can($this->context->getPermissionPrefix() . 'View') || Yii::$app->user->can('userProfileOwner', ['userId' => $model->id, ]);
};
$actionColumn['visibleButtons']['update'] = function($model, $key, $index){
    return Yii::$app->user->can($this->context->getPermissionPrefix() . 'Update') || Yii::$app->user->can('userProfileOwner', ['userId' => $model->id, ]);
};

$columns[] = $actionColumn;

?>

<div class="user-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php if(Yii::$app->user->can('userCreate')){echo Html::a('Зарегистрировать нового пользователя', ['auth/signup'], ['class' => 'btn btn-success']);} ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider'  => $dataProvider,
        'filterModel'   => $searchModel,
        'columns'       => $columns,
        'pager'         => ['class' => 'yii\bootstrap4\LinkPager'],
    ]); ?>

</div>
