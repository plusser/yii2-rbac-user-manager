<?php

use yii\helpers\Html;
use yii\grid\GridView;
use rbacUserManager\helpers\ViewHelper;

$this->title = 'Разрешения';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="permission-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php echo $this->context->getCreateButton('Создать разрешение'); ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider'  => $dataProvider,
        'filterModel'   => $searchModel,
        'pager'         => ['class' => 'yii\bootstrap4\LinkPager'],
        'columns'       => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'ruleName',
                'filter'    => $searchModel->rulesFilter,
            ],
            'description',
            ViewHelper::GridViewDateTimeColumn($searchModel, 'createdAt'),
            ViewHelper::GridViewDateTimeColumn($searchModel, 'updatedAt'),
            $this->context->getActionColumn(),
        ],
    ]); ?>

</div>
