<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Правила';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="rule-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
		'options' => [
			'style' => 'white-space: normal !important; word-break: break-all !important;',
		],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'label' => 'Класс',
                'value' => function($data){return $data->modelClass;},
            ],
            [
                'attribute' => 'description',
                'value' => function($data){return isset($data->description) ? nl2br($data->description) : NULL;},
                'format' => 'raw',
            ],
			[
				'attribute' => 'createdAt',
				'value' => function($data){return date('Y-m-d H:i:s', $data->createdAt);},
			],
			[
				'attribute' => 'updatedAt',
				'value' => function($data){return date('Y-m-d H:i:s', $data->updatedAt);},
			],
        ],
    ]); ?>

</div>
