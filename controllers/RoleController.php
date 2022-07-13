<?php 

namespace rbacUserManager\controllers;

use crud\controllers\CRUDController;
use rbacUserManager\models\RoleForm;
use rbacUserManager\models\RoleSearch;

class RoleController extends CRUDController
{

    public function getModelClass()
    {
        return RoleForm::class;
    }

    public function getModelSearch()
    {
        return new RoleSearch;
    }

    public function getPermissionPrefix()
    {
        return 'role';
    }

}
