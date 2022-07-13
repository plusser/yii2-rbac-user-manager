<?php

use yii\helpers\Html;
use yii\grid\GridView;
use rbacUserManager\helpers\ViewHelper;

$this->title = 'Роли';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="role-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php echo $this->context->getCreateButton('Создать роль'); ?>
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
