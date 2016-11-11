<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Разрешения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php if(Yii::$app->user->can('permissionCreate')){echo Html::a('Создать разрешение', ['create'], ['class' => 'btn btn-success']);} ?>
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
                        return Yii::$app->user->can('permissionView') ? Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url) : '';
                    },
                    'update' => function ($url, $model, $key){
                        return Yii::$app->user->can('permissionUpdate') ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url) : '';
                    },
                    'delete' => function ($url, $model, $key){
                        return Yii::$app->user->can('permissionDelete') ? Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
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
