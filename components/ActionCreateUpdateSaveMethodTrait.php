<?php 

namespace rbacUserManager\components;

use Yii;

trait ActionCreateUpdateSaveMethodTrait
{

    protected function save($model, $viewName, $PKAttribute = 'id')
	{
		return (is_object($model) AND $model->load(Yii::$app->request->post()) AND $model->save()) ? $this->redirect([
			'view',
			'id' => $model->{$PKAttribute},
		]) : $this->render($viewName, [
            'model' => $model,
        ]);
	}

}
