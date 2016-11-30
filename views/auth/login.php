<?php 

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="auth-login">
    <h1><?php echo Html::encode($this->title); ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?php echo $form->field($model, 'username')->textInput(['autofocus' => true, ]); ?>

                <?php echo $form->field($model, 'password')->passwordInput(); ?>

                <?php if($model->rememberMe){echo $form->field($model, 'rememberMe')->checkbox();} ?>

                <div style="color:#999;margin:1em 0">
                    Если вы забыли пароль, вы можете его <?php echo  Html::a('восстановить', ['request-password-reset']); ?>.
                </div>

                <div class="form-group">
                    <?php echo Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button', ]); ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
