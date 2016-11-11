<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

$columns = [
	'id',
	'username',
	[
		'attribute' => 'email',
		'content' => function($data){return Html::a($data->email, 'mailto:' . $data->email);},
	],
	[
		'attribute' => 'status',
		'value' => function($data){return $data->status == $data::STATUS_ACTIVE ? 'Да' : 'Нет';},
	],
	[
		'attribute' => 'created_at',
		'value' => function($data){return date('Y-m-d H:i:s', $data->created_at);},
	],
	[
		'attribute' => 'updated_at',
		'value' => function($data){return date('Y-m-d H:i:s', $data->updated_at);},
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
	'class' => 'yii\grid\ActionColumn',
	'buttons' => [
		'view' => function ($url, $model, $key){
			return (Yii::$app->user->can('userView') OR Yii::$app->user->can('userProfileOwner', ['userId' => $model->id, ])) ? Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url) : '';
		},
		'update' => function ($url, $model, $key){
			return (Yii::$app->user->can('userUpdate') OR Yii::$app->user->can('userProfileOwner', ['userId' => $model->id, ])) ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url) : '';
		},
		'delete' => function ($url, $model, $key){
			return Yii::$app->user->can('userDelete') ? Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
				'data' => [
					'confirm' => 'Точно удалить?',
					'method' => 'post',
				],
			]) : '';
		},
	],
];

?>

<div class="user-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php if(Yii::$app->user->can('userCreate')){echo Html::a('Зарегистрировать нового пользователя', ['auth/signup'], ['class' => 'btn btn-success']);} ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,
    ]); ?>

</div>
