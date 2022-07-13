<?php 

namespace rbacUserManager\components;

use yii\rbac\Rule;
 
class UserProfileOwnerRule extends Rule
{

    public $name = 'isUserProfileOwner';
    public $description = '<p>Сравнение ID текущего пользователя с переданным $params[\'userId\'].</p><b>Например:</b> <i>if(Yii::$app->user->can(\'userProfileOwner\', [\'userId\' => $model->id, ])){...}</i>';

    public function execute($userId, $item, $params)
    {
        return isset($params['userId']) ? $userId == $params['userId'] : false;
    }

}
