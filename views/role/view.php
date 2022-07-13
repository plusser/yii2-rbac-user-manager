<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap4\Tabs;

$this->params['breadcrumbs'][] = ['label' => 'Роли', 'url' => ['index']];
$this->title = 'Роль ' . ($this->params['breadcrumbs'][] = $model->name);

?>

<div class="role-view">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php if(Yii::$app->user->can('roleUpdate')){echo Html::a('Редактировать', ['update', 'id' => $model->name], ['class' => 'btn btn-success', ]);} ?>
        <?php if(Yii::$app->user->can('roleDelete')){echo Html::a('Удалить', ['delete', 'id' => $model->name, ], [
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
                'value' => date('d-m-Y H:i:s', $model->createdAt),
            ],
            [
                'attribute' => 'updatedAt',
                'value' => date('d-m-Y H:i:s', $model->updatedAt),
            ],
            [
                'attribute' => 'children',
                'value' => (($F = function($model){
                    $children = [
                        'role' => [],
                        'permission' => [],
                    ];
                    foreach($model->children as $item){
                        $children[$item->type == $item::TYPE_ROLE ? 'role' : 'permission'][$item->name] = $item;
                    }
                    return Tabs::widget([
                        'items' => [
                            [
                                'label' => 'Роли (' . count($children['role']) . ')',
                                'content' => $this->render('_childrenView', ['children' => $children['role'], ]),
                            ],
                            [
                                'label' => 'Разрешения (' . count($children['permission']) . ')',
                                'content' => $this->render('_childrenView', ['children' => $children['permission'], ]),
                            ],
                            [
                                'label' => 'Итого разрешений (' . count($C = Yii::$app->authManager->getPermissionsByRole($model->name)) . ')',
                                'content' => $this->render('_childrenView', ['children' => $C, ]),
                                'active' => true,
                            ],
                        ],
                    ]);
                }) ? $F($model) : NULL),
                'format' => 'raw',
            ],
        ],
    ]); ?>

</div>
