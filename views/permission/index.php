<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\jui\DatePicker;

$this->title = 'Разрешения';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="permission-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php echo $this->context->getCreateButton('Создать разрешение'); ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'ruleName',
                'filter' => $searchModel->rulesFilter,
            ],
            'description',
            [
                'attribute' => 'createdAt',
                'filterOptions' => [
                    'style'	=> 'width: 180px;',
                ],
                'contentOptions' => [
                    'style'	=> 'text-align: center;',
                ],
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute'=>'createdAt',
                    'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => [
                        'class'	=> 'form-control',
                    ],
                ]),
                'value' => function($data){return date('d-m-Y H:i:s', $data->createdAt);},
            ],
            [
                'attribute' => 'updatedAt',
                'filterOptions' => [
                    'style'	=> 'width: 180px;',
                ],
                'contentOptions' => [
                    'style'	=> 'text-align: center;',
                ],
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updatedAt',
                    'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => [
                        'class'	=> 'form-control',
                    ],
                ]),
                'value' => function($data){return date('d-m-Y H:i:s', $data->updatedAt);},
            ],
            [
                'class' => ActionColumn::class,
                'headerOptions' => [
                    'style' => 'width: 80px;',
                ],
                'visibleButtons' => [
                    'view' => Yii::$app->user->can('permissionView'),
                    'update' => Yii::$app->user->can('permissionUpdate'),
                    'delete' => Yii::$app->user->can('permissionDelete'),
                ],
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

</div>
