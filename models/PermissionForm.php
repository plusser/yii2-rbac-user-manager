<?php 

namespace rbacUserManager\models;

class PermissionForm extends AbstractAuthItemForm
{

    public static function authItemTypeName(): string
    {
        return 'permission';
    }

}
