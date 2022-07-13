<?php 

namespace rbacUserManager\models;

class RoleForm extends AbstractAuthItemForm
{

    public static function authItemTypeName(): string
    {
        return 'role';
    }

}
