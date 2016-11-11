<?php 

namespace rbacUserManager\components;

trait ActionDeleteTrait
{

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    abstract protected function findModel($id);

}
