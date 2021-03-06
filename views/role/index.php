<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Роли';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="role-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php if(Yii::$app->user->can('roleCreate')){echo Html::a('Создать роль', ['create'], ['class' => 'btn btn-success']);} ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'ruleName',
			'description',
			[
				'attribute' => 'createdAt',
				'value' => function($data){return date('Y-m-d H:i:s', $data->createdAt);},
			],
			[
				'attribute' => 'updatedAt',
				'value' => function($data){return date('Y-m-d H:i:s', $data->updatedAt);},
			],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key){
                        return Yii::$app->user->can('roleView') ? Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url) : '';
                    },
                    'update' => function ($url, $model, $key){
                        return Yii::$app->user->can('roleUpdate') ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url) : '';
                    },
                    'delete' => function ($url, $model, $key){
                        return Yii::$app->user->can('roleDelete') ? Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'data' => [
                                'confirm' => 'Точно удалить?',
                                'method' => 'post',
                            ],
                        ]) : '';
                    },
                ],
            ],
        ],
    ]); ?>

</div>
