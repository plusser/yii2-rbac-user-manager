<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\jui\DatePicker;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    [
        'attribute' => 'id',
        'filterOptions' => [
            'style'	=> 'width: 100px;',
        ],
    ],
    'username',
    [
        'attribute' => 'email',
        'content' => function($data){return Html::a($data->email, 'mailto:' . $data->email);},
    ],
    [
        'attribute' => 'status',
        'filter' => [
            $searchModel::STATUS_ACTIVE => 'Да',
            $searchModel::STATUS_DELETED => 'Нет',
        ],
        'filterOptions' => [
            'style'	=> 'width: 100px;',
        ],
        'contentOptions' => [
            'style'	=> 'text-align: center;',
        ],
        'value' => function($data){return $data->status == $data::STATUS_ACTIVE ? 'Да' : 'Нет';},
    ],
    [
        'attribute' => 'created_at',
        'filterOptions' => [
            'style'	=> 'width: 180px;',
        ],
        'contentOptions' => [
            'style'	=> 'text-align: center;',
        ],
        'filter' => DatePicker::widget([
            'model' => $searchModel,
            'attribute' => 'created_at',
            'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => [
                'class'	=> 'form-control',
            ],
        ]),
        'value' => function($data){return date('d-m-Y H:i:s', $data->created_at);},
    ],
    [
        'attribute' => 'updated_at',
        'filterOptions' => [
            'style'	=> 'width: 180px;',
        ],
        'contentOptions' => [
            'style'	=> 'text-align: center;',
        ],
        'filter' => DatePicker::widget([
            'model' => $searchModel,
            'attribute' => 'updated_at',
            'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => [
                'class'	=> 'form-control',
            ],
        ]),
        'value' => function($data){return date('d-m-Y H:i:s', $data->updated_at);},
    ],
];

if(is_array($userAdditionalIndex = Yii::$app->controller->module->userAdditionalIndex)){

    $className = $userAdditionalIndex[0];
    $method = $userAdditionalIndex[1];

    foreach($className::$method() as $item){
        $columns[] = $item;
    }
}

$columns[] = [
    'class' => ActionColumn::class,
    'headerOptions' => [
        'style' => 'width: 80px;',
    ],
    'visibleButtons' => [
        'view' => Yii::$app->user->can('userView') || Yii::$app->user->can('userProfileOwner', ['userId' => $model->id, ]),
        'update' => Yii::$app->user->can('userUpdate') || Yii::$app->user->can('userProfileOwner', ['userId' => $model->id, ]),
        'delete' => Yii::$app->user->can('userDelete'),
    ],
    'urlCreator' => function ($action, $model, $key, $index, $column) {
        return Url::toRoute([$action, 'id' => $model->id]);
    }
];

?>

<div class="user-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php if(Yii::$app->user->can('userCreate')){echo Html::a('Зарегистрировать нового пользователя', ['auth/signup'], ['class' => 'btn btn-success']);} ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager',
        ],
    ]); ?>

</div>
