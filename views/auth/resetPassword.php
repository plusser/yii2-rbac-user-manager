<?php 

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановить пароль';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-reset-password">
    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>Введите новый пароль:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?php echo $form->field($model, 'password')->passwordInput(['autofocus' => true, ]); ?>

                <div class="form-group">
                    <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']); ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
