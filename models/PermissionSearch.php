<?php 

namespace rbacUserManager\models;

use Yii;
use rbacUserManager\components\AuthItemSearchTrait;

class PermissionSearch extends PermissionForm
{

    use AuthItemSearchTrait;

    public function getModelClass(): string
    {
        return PermissionForm::class;
    }

    protected function getDataList(): array
    {
        return Yii::$app->authManager->getPermissions();
    }

}
