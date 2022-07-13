<?php 

namespace rbacUserManager\controllers;

use crud\controllers\CRUDController;
use rbacUserManager\models\PermissionForm;
use rbacUserManager\models\PermissionSearch;


class PermissionController extends CRUDController
{

    public function getModelClass()
    {
        return PermissionForm::class;
    }

    public function getModelSearch()
    {
        return new PermissionSearch;
    }

    public function getPermissionPrefix()
    {
        return 'permission';
    }

}
