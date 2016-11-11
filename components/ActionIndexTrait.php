<?php 

namespace rbacUserManager\components;

trait ActionIndexTrait
{

    public function actionIndex()
    {
        return $this->render('index', [
            'dataProvider' => $this->getDataProvider(),
        ]);
    }

    abstract protected function getDataProvider();

}
