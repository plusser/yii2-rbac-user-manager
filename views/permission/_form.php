<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
	<div class="permission-form">

		<?php $form = ActiveForm::begin(); ?>

		<?php echo $form->field($model, 'name')->textInput(['autofocus' => true]); ?>

        <?php echo $form->field($model, 'ruleName')->dropDownList(array_merge([NULL => 'Нет', ], array_combine($R = array_keys(Yii::$app->authManager->getRules()), $R))); ?>

		<?php echo $form->field($model, 'description')->textArea(); ?>

		<div class="form-group">
			<?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success', ]); ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
