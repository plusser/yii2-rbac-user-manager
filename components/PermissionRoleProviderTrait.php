<?php 

namespace rbacUserManager\components;

use yii\data\ArrayDataProvider;
use rbacUserManager\models\PermissionRoleForm;

trait PermissionRoleProviderTrait
{

    protected function getDataProvider()
    {
		$allModels = [];

		foreach($this->getDataList() as $item){
			$allModels[$item->name] = new PermissionRoleForm($item);
		}

        return new ArrayDataProvider([
            'allModels' => $allModels,
            'pagination' => [
                'pageSize' => $this->module->paginationPageSize,
            ],
            'sort' => [
                'attributes' => ['name', 'createdAt', 'updatedAt', ],
            ],
        ]);
    }

    abstract protected function getDataList();

}
