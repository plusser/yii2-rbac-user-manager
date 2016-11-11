<?php 

use yii\helpers\Html;

?>
<div class="password-reset">
    <p>Здравствуйте, <?php echo Html::encode($user->username); ?>!</p>

    <p>Чтобы восстановить пароль пройдите по ссылке ниже:</p>

    <p><?php echo Html::a(Html::encode($resetLink = Yii::$app->urlManager->createAbsoluteUrl(['rbacUserManager/auth/reset-password', 'token' => $user->password_reset_token, ])), $resetLink); ?></p>
</div>
