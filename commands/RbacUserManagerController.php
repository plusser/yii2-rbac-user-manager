<?php

namespace rbacUserManager\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use rbacUserManager\components\ConsoleCommandTrait;
use rbacUserManager\components\MigrationTrait;
use rbacUserManager\models\SignupForm;
use rbacUserManager\models\User;

class RbacUserManagerController extends Controller
{

    use ConsoleCommandTrait;
    use MigrationTrait;

    public $user;
    public $email;
    public $password;
    public $role;
    public $force;
    
    public function options($actionID)
    {
        return [
            'user',
            'email',
            'password',
            'role',
            'force',
        ];
    }

    public function optionAliases()
    {
        return [
            'u' => 'user',
            'e' => 'email',
            'p' => 'password',
            'r' => 'role',
            'f' => 'force',
        ];
    }

    public function actionInit()
    {
        $initItems = require(__DIR__ . '/initItems.php');

        $this->addRules($initItems['rules']);
        $this->addPermissions($initItems['permissions']);
        $this->addRoles($initItems['roles']);

        return $this->exitCode();
    }

    public function actionListPermissions()
    {
        return $this->listRbacItems(Yii::$app->authManager->getPermissions(), 'Разрешения');
    }

    public function actionListRoles()
    {
        return $this->listRbacItems(Yii::$app->authManager->getRoles(), 'Роли');
    }

    protected function listRbacItems($list, $name)
    {
        $this->stdout(PHP_EOL . PHP_EOL . $name . ':' . PHP_EOL . PHP_EOL, Console::BOLD);

        foreach($list as $item){
            $this->stdout("\t" . $item->name, Console::BOLD);
            $item->ruleName ? $this->stdout("\t" . $item->ruleName, Console::FG_RED) : $this->stdout("\t" . 'не задано', Console::FG_GREY);
            $item->description ? $this->stdout("\t" . $item->description . PHP_EOL, Console::FG_YELLOW) : $this->stdout("\t" . 'не задано' . PHP_EOL, Console::FG_GREY);
        }

        $this->stdout(PHP_EOL . PHP_EOL);

        return $this->exitCode();
    }

    public function actionListRules()
    {
        $this->stdout(PHP_EOL . PHP_EOL . 'Правила:' . PHP_EOL . PHP_EOL, Console::BOLD);

        foreach(Yii::$app->authManager->getRules() as $item){
            $this->stdout("\t" . $item->name, Console::BOLD);
            $this->stdout("\t" . $item::class, Console::FG_GREEN);
            $item->description ? $this->stdout("\t" . $item->description . PHP_EOL, Console::FG_YELLOW) : $this->stdout("\t" . 'не задано' . PHP_EOL, Console::FG_GREY);
        }

        $this->stdout(PHP_EOL . PHP_EOL);

        return $this->exitCode();
    }
    
    public function actionListUser()
    {
        $this->stdout(PHP_EOL . PHP_EOL . 'Пользователи:' . PHP_EOL . PHP_EOL, Console::BOLD);

        foreach(User::find()->all() as $item){
            $this->stdout("\t" . $item->username, Console::BOLD);
            $this->stdout("\t" . $item->email, Console::FG_YELLOW);
            $item->status == User::STATUS_ACTIVE ? $this->stdout("\t" . 'активен' . PHP_EOL, Console::FG_GREEN) : $this->stdout("\t" . 'заблокирован' . PHP_EOL, Console::FG_RED);
        }

        $this->stdout(PHP_EOL . PHP_EOL);

        return $this->exitCode();
    }

    public function actionCreateUser()
    {
        $error = $this->checkTransferOptions(['user', 'email', 'password', ]);

        if(!$error){
            $model = new SignupForm();
            $model->setAttributes([
                'username'  => $this->user,
                'email'     => $this->email,
                'password'  => $this->password,
            ]);

            if(is_object($model->signup())){
                $this->stdout('Пользователь ', Console::BOLD);
                $this->stdout($this->user, Console::FG_GREEN);
                $this->stdout(' создан' . PHP_EOL, Console::BOLD);

                if($this->role){
                    $error = ($this->exitCode() != $this->actionAddUserRole());
                }
            }else{
                $this->printErrors($model);
                $error = true;
            }
        }

        return $this->exitCode($error);
    }

    public function actionEnableUser()
    {
        return $this->statusChange(User::STATUS_ACTIVE, 'активирован');
    }

    public function actionDisableUser()
    {
        return $this->statusChange(User::STATUS_DELETED, 'заблокирован');
    }

    protected function statusChange($status, $statusName)
    {
        $error = $this->findUser($this->checkTransferOptions(['user', ]));

        if(!$error){
            if($this->user->status == $status){
                $this->stdout('Пользователь ', Console::BOLD);
                $this->stdout($this->user->username, Console::FG_YELLOW);
                $this->stdout(' уже ' . $statusName . PHP_EOL, Console::BOLD);
            }else{
                $this->user->status = $status;
                if($this->user->save()){                
                    $this->stdout('Пользователь ', Console::BOLD);
                    $this->stdout($this->user->username, Console::FG_GREEN);
                    $this->stdout(' ' . $statusName . PHP_EOL, Console::BOLD);
                }else{
                    $this->printErrors($this->user);
                    $error = true;
                }
            }
        }

        return $this->exitCode($error);
    }

    public function actionDeleteUser()
    {
        $error = $this->findUser($this->checkTransferOptions(['user', ]));

        if(!$error){
            $this->user->delete();
            $this->stdout('Пользователь ', Console::BOLD);
            $this->stdout($this->user->username, Console::FG_GREEN);
            $this->stdout(' удален' . PHP_EOL, Console::BOLD);
        }

        return $this->exitCode($error);
    }

    public function actionAddUserRole()
    {
        $error = $this->findRole($this->findUser($this->checkTransferOptions(['user', 'role', ])));

        if(!$error && !is_object($A = Yii::$app->authManager->getAssignment($this->role->name, $this->user->id))){
            Yii::$app->authManager->assign($this->role, $this->user->id);

            $this->stdout('Пользователю ', Console::BOLD);
            $this->stdout($this->user->username, Console::FG_GREEN);
            $this->stdout(' добавлена роль ', Console::BOLD);
            $this->stdout($this->role->name . ' (' . ($this->role->description ? $this->role->description : '...') . ')' . PHP_EOL, Console::FG_GREEN);
        }

        return $this->exitCode($error);
    }

    public function actionRemoveUserRole()
    {
        $error = $this->findRole($this->findUser($this->checkTransferOptions(['user', 'role', ])));

        if(!$error && is_object(Yii::$app->authManager->getAssignment($this->role->name, $this->user->id))){
            Yii::$app->authManager->revoke($this->role, $this->user->id);

            $this->stdout('У пользователя ', Console::BOLD);
            $this->stdout($this->user->username, Console::FG_GREEN);
            $this->stdout(' исключена роль ', Console::BOLD);
            $this->stdout($this->role->name . ' (' . ($this->role->description ? $this->role->description : '...') . ')' . PHP_EOL, Console::FG_GREEN);
        }

        return $this->exitCode($error);
    }
    
    protected function findRole($error)
    {
        if(!$error && !is_object($role = Yii::$app->authManager->getRole($this->role))){
            $this->roleNotFound($this->role);
            $error = true;
        }elseif(!$error){
            $this->role = $role;
        }

        return $error;
    }

    protected function findUser($error)
    {
        if(!$error && !is_object($user = User::findOne(['username' => $this->user, ]))){
            $this->userNotFound($this->user);
            $error = true;
        }elseif(!$error){
            $this->user = $user;
        }

        return $error;
    }

    protected function roleNotFound($role)
    {
        $this->stdout('Роль ', Console::BOLD);
        $this->stdout($role, Console::FG_RED);
        $this->stdout(' не существует' . PHP_EOL, Console::BOLD);
    }

    protected function userNotFound($user)
    {
        $this->stdout('Пользователь ', Console::BOLD);
        $this->stdout($user, Console::FG_RED);
        $this->stdout(' не существует' . PHP_EOL, Console::BOLD);
    }

}
