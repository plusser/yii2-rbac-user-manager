<?php 

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановить пароль';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="auth-request-password-reset">
    <h1><?php echo Html::encode($this->title); ?></h1>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form', ]); ?>

                <?php echo $form->field($model, 'email')->textInput(['autofocus' => true, ]); ?>

                <div class="form-group">
                    <?php echo Html::submitButton('Восстановить', ['class' => 'btn btn-primary', ]); ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
