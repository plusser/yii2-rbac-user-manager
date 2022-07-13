<?php

use yii\helpers\Html;
use yii\grid\GridView;
use rbacUserManager\helpers\ViewHelper;

$this->title = 'Правила';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="rule-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <?php echo GridView::widget([
        'dataProvider'  => $dataProvider,
        'filterModel'   => $searchModel,
        'pager'         => ['class' => 'yii\bootstrap4\LinkPager'],
        'options'       => ['style' => 'white-space: normal !important; word-break: break-all !important;'],
        'columns'       => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'modelClass',
                'value'     => function($data){return $data->modelClass;},
            ],
            [
                'attribute' => 'description',
                'value'     => function($data){return isset($data->description) ? nl2br($data->description) : NULL;},
                'format'    => 'raw',
            ],
            ViewHelper::GridViewDateTimeColumn($searchModel, 'createdAt'),
            ViewHelper::GridViewDateTimeColumn($searchModel, 'updatedAt'),
        ],
    ]); ?>

</div>
