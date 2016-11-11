<?php 

namespace rbacUserManager\components;

trait ActionViewTrait
{

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    abstract protected function findModel($id);

}
