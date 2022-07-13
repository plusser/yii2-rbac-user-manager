<?php 

namespace rbacUserManager\models;

use Yii;
use rbacUserManager\components\AuthItemSearchTrait;

class RoleSearch extends RoleForm
{

    use AuthItemSearchTrait;

    public function getModelClass(): string
    {
        return RoleForm::class;
    }

    protected function getDataList(): array
    {
        return Yii::$app->authManager->getRoles();
    }

}
