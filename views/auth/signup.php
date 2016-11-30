<?php 

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация нового пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['user/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="auth-signup">
    <h1><?php echo Html::encode($this->title); ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?php echo $form->field($model, 'username')->textInput(['autofocus' => true]); ?>

                <?php echo $form->field($model, 'email'); ?>

                <?php echo $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?php echo Html::submitButton('Готово', ['class' => 'btn btn-success', 'name' => 'signup-button']); ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
