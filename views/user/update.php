<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Accordion;

$this->title = 'Редактировать пользователя ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id, ]];
$this->params['breadcrumbs'][] = 'Редактировать';

?>

<div class="user-update">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?php echo $form->field($model, 'username')->textInput(['autofocus' => true]); ?>

        <?php echo $form->field($model, 'email'); ?>

        <?php echo $form->field($model, 'status')->dropDownList([
            $model::STATUS_ACTIVE   => 'Да',
            $model::STATUS_DELETED  => 'Нет',
        ]); ?>

        <?php if($userAdditionalForm = Yii::$app->controller->module->userAdditionalForm){
            echo $userAdditionalForm::widget([
                'form' => $form,
                'model' => $model,
            ]);
        } ?>

        <?php if(Yii::$app->user->can('userRoleUpdate')){echo Accordion::widget([
            'options'   => ['class' => 'form-group'],
            'items'     => [
                [
                    'label'             => 'Роли',
                    'content'           => $this->render('_roleListForm', ['userRoleList' => $model->roleList, 'itemList' => Yii::$app->authManager->getRoles()]),
                    'contentOptions'    => ['class' => 'out']
                ],
            ],
        ]);} ?>

        <div class="form-group">
            <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']); ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
