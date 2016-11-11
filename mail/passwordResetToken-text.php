Здравствуйте, <?php echo Html::encode($user->username); ?>!

Чтобы восстановить пароль пройдите по ссылке ниже:

<?php echo $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['rbacUserManager/auth/reset-password', 'token' => $user->password_reset_token, ]); ?>
