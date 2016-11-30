<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = ['label' => 'Разрешения', 'url' => ['index']];
$this->title = 'Разрешение ' . ($this->params['breadcrumbs'][] = $model->name);

?>

<div class="permission-view">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php if(Yii::$app->user->can('permissionUpdate')){echo Html::a('Редактировать', ['update', 'id' => $model->name], ['class' => 'btn btn-success', ]);} ?>
        <?php if(Yii::$app->user->can('permissionDelete')){echo Html::a('Удалить', ['delete', 'id' => $model->name, ], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Точно удалить?',
                'method' => 'post',
            ],
        ]);} ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
			'name',
            'ruleName',
			'description',
			[
				'attribute' => 'createdAt',
				'value' => date('Y-m-d H:i:s', $model->createdAt),
			],
			[
				'attribute' => 'updatedAt',
				'value' => date('Y-m-d H:i:s', $model->updatedAt),
			],
        ],
    ]); ?>

</div>
