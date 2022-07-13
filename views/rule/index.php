<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;

$this->title = 'Правила';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="rule-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager',
        ],
        'options' => [
            'style' => 'white-space: normal !important; word-break: break-all !important;',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'modelClass',
                'value' => function($data){return $data->modelClass;},
            ],
            [
                'attribute' => 'description',
                'value' => function($data){return isset($data->description) ? nl2br($data->description) : NULL;},
                'format' => 'raw',
            ],
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
                    'attribute' => 'createdAt',
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
        ],
    ]); ?>

</div>
