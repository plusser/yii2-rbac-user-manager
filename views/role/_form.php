<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Collapse;
use yii\bootstrap\Tabs;

?>
	<div class="role-form">

		<?php $form = ActiveForm::begin(); ?>

		<?php echo $form->field($model, 'name')->textInput(['autofocus' => true]); ?>

        <?php echo $form->field($model, 'ruleName')->dropDownList(array_merge([NULL => 'Нет', ], array_combine($R = array_keys(Yii::$app->authManager->getRules()), $R))); ?>

		<?php echo $form->field($model, 'description')->textArea(); ?>

		<?php echo Collapse::widget([
			'items' => [
				[
					'label' => 'Включает в себя',
					'content' => Tabs::widget([
						'items' => [
							[
								'label' => 'Роли',
								'content' => $this->render('_childrenForm', ['model' => $model, 'children' => Yii::$app->authManager->getRoles(), ]),
								'active' => true,
							],
							[
								'label' => 'Разрешения',
								'content' => $this->render('_childrenForm', ['model' => $model, 'children' => Yii::$app->authManager->getPermissions(), ]),
							],
						],
					]),
					'contentOptions' => ['class' => 'out',]
				],
			],
		]); ?>

		<div class="form-group">
			<?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success', ]); ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
