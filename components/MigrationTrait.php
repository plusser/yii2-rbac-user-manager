<?php

namespace rbacUserManager\components;

use Yii;
use yii\helpers\Console;
use rbacUserManager\models\PermissionForm;
use rbacUserManager\models\RoleForm;

trait MigrationTrait
{

    public function stdout($string)
    {
        if(count($args = func_get_args()) > 1){
            array_shift($args);
            $string = Console::ansiFormat($string, $args);
        }

        return Console::stdout($string);
    }

    protected function printErrors($model)
    {
        $this->stdout(PHP_EOL);

        foreach($model->errors as $fieldErrors){
            foreach($fieldErrors as $item){
                $this->stdout($item . PHP_EOL, Console::FG_RED);
            }
        }

        $this->stdout(PHP_EOL);
    }

    protected function addRules(array $rules): void
    {
        $this->stdout(PHP_EOL . 'Правила:' . PHP_EOL . PHP_EOL, Console::BOLD);

        foreach($rules as $item){
            $newRuleModel = new $item;
            $this->stdout("\t" . $newRuleModel->name, Console::BOLD);

            if(!is_object($ruleModel = Yii::$app->authManager->getRule($newRuleModel->name)) || ($this->force ?? false)){
                if(!is_object($ruleModel)){
                    Yii::$app->authManager->add($newRuleModel);
                    $this->stdout("\t" . 'добавлено' . PHP_EOL, Console::FG_GREEN);
                }else{
                    Yii::$app->authManager->update($newRuleModel->name, $newRuleModel);
                    $this->stdout("\t" . 'обновлено' . PHP_EOL, Console::FG_YELLOW);
                }
            }else{
                $this->stdout("\t" . 'пропущено (уже имеется правило с таким именем)' . PHP_EOL, Console::FG_RED);
            }
        }

        $this->stdout(PHP_EOL);
    }

    protected function addPermissions(array $permissions): void
    {
        $this->stdout(PHP_EOL . 'Разрешения:' . PHP_EOL . PHP_EOL, Console::BOLD);

        foreach($permissions as $item){
            $this->stdout("\t" . $item['name'], Console::BOLD);

            if(!is_object($permissionModel = Yii::$app->authManager->getPermission($item['name'])) || ($this->force ?? false)){
                $model = new PermissionForm($permissionModel ? $permissionModel : Yii::$app->authManager->createPermission(null));
                $model->setAttributes($item);
                if($model->save()){
                    is_object($permissionModel) ? $this->stdout("\t" . 'обновлено' . PHP_EOL, Console::FG_YELLOW) : $this->stdout("\t" . 'добавлено' . PHP_EOL, Console::FG_GREEN);
                }else{
                    $this->printErrors($model);
                }
            }else{
                $this->stdout("\t" . 'пропущено (уже имеется разрешение с таким именем)' . PHP_EOL, Console::FG_RED);
            }
        }

        $this->stdout(PHP_EOL);
    }

    protected function addRoles(array $roles): void
    {
        $this->stdout(PHP_EOL . 'Роли:' . PHP_EOL . PHP_EOL, Console::BOLD);

        foreach($roles as $item){
            $this->stdout("\t" . $item['name'], Console::BOLD);

            if(!is_object($roleModel = Yii::$app->authManager->getRole($item['name'])) || ($this->force ?? false)){
                $model = new RoleForm($roleModel ? $roleModel : Yii::$app->authManager->createRole(null));
                $model->setAttributes($item);
                if($model->save()){
                    is_object($roleModel) ? $this->stdout("\t" . 'обновлена' . PHP_EOL, Console::FG_YELLOW) : $this->stdout("\t" . 'добавлена' . PHP_EOL, Console::FG_GREEN);
                }else{
                    $this->printErrors($model);
                }
            }else{
                $this->stdout("\t" . 'пропущено (уже имеется роль с таким именем)' . PHP_EOL, Console::FG_RED);
            }
        }

        $this->stdout(PHP_EOL . PHP_EOL);
    }

    protected function deleteRules(array $rules): void
    {
        $this->stdout(PHP_EOL . 'Правила:' . PHP_EOL . PHP_EOL, Console::BOLD);

        foreach($rules as $item){
            $this->stdout("\t" . $item['name'], Console::BOLD);

            if(is_object($ruleModel = Yii::$app->authManager->getRule($item['name']))){
                Yii::$app->authManager->remove($ruleModel) ? $this->stdout("\t" . 'удалено' . PHP_EOL, Console::FG_GREEN) : $this->stdout("\t" . 'ошибка при удалении' . PHP_EOL, Console::FG_RED);
            }else{
                $this->stdout("\t" . 'пропущено (нет правила с таким именем)' . PHP_EOL, Console::FG_RED);
            }
        }

        $this->stdout(PHP_EOL);
    }

    protected function deletePermissions(array $permissions): void
    {
        $this->stdout(PHP_EOL . 'Разрешения:' . PHP_EOL . PHP_EOL, Console::BOLD);

        foreach($permissions as $item){
            $this->stdout("\t" . $item['name'], Console::BOLD);

            if(is_object($permissionModel = Yii::$app->authManager->getPermission($item['name']))){
                Yii::$app->authManager->remove($permissionModel) ? $this->stdout("\t" . 'удалено' . PHP_EOL, Console::FG_GREEN) : $this->stdout("\t" . 'ошибка при удалении' . PHP_EOL, Console::FG_RED);
            }else{
                $this->stdout("\t" . 'пропущено (нет разрешения с таким именем)' . PHP_EOL, Console::FG_RED);
            }
        }

        $this->stdout(PHP_EOL);
    }

    protected function deleteRoles(array $roles): void
    {
        $this->stdout(PHP_EOL .'Роли:' . PHP_EOL . PHP_EOL, Console::BOLD);

        foreach($roles as $item){
            $this->stdout("\t" . $item['name'], Console::BOLD);

            if(is_object($roleModel = Yii::$app->authManager->getRole($item['name']))){
                Yii::$app->authManager->remove($roleModel) ? $this->stdout("\t" . 'удалена' . PHP_EOL, Console::FG_GREEN) : $this->stdout("\t" . 'ошибка при удалении' . PHP_EOL, Console::FG_RED);
            }else{
                $this->stdout("\t" . 'пропущено (нет роли с таким именем)' . PHP_EOL, Console::FG_RED);
            }
        }

        $this->stdout(PHP_EOL);
    }

}
