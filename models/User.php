<?php 

namespace rbacUserManager\models;

use Yii;
use common\models\User AS commonUser;
use yii\rbac\Assignment;

class User extends commonUser
{

    protected $_roleList = [];

	public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'username' => 'Логин',
            'email' => 'Электронная почта',
			'password' => 'Пароль',
            'status' => 'Активен',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'roleList' => 'Роли',
            'permissionList' => 'Разрешения',
        ]);
    }

    public function rules()
    {
        $result = parent::rules();

        foreach([
            ['username', 'trim', ],
            ['username', 'required', ],
            ['username', 'unique', 'targetClass' => get_class($this), 'message' => 'Пользователь с таким логином уже существует.', ],
            ['username', 'string', 'min' => 2, 'max' => 255, ],

            ['email', 'trim', ],
            ['email', 'required'],
            ['email', 'email', ],
            ['email', 'string', 'max' => 255, ],
            ['email', 'unique', 'targetClass' => get_class($this), 'message' => 'Пользователь с такой электронной почтой уже существует.', ],
            [['roleList', 'permissionList', ], 'safe', ],
        ] as $item){
            $result[] = $item;
        }

        return $result;
    }

    public function getPermissionList()
    {
        return Yii::$app->authManager->getPermissionsByUser($this->id);
    }

    public function setPermissionList()
    {
        return $this;
    }

    public function getRoleList()
    {
        return (empty($this->_roleList) AND !$this->hasErrors()) ? Yii::$app->authManager->getAssignments($this->id) : $this->_roleList;
    }

    public function setRoleList($roleList)
	{
		if(!empty($roleList)){
			$this->_roleList = [];
			foreach((array) $roleList as $itemName){
				if(is_object($item = Yii::$app->authManager->getAssignment($itemName, $this->id)) OR is_object($item = new Assignment)){
                    $item->userId = $this->id;
                    $item->roleName = $itemName;
					$this->_roleList[$itemName] = $item;
				}
			}
		}

		return $this;
	}

    public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes);

		if(!$this->hasErrors() AND ((Yii::$app instanceof yii\console\Application) OR Yii::$app->user->can('userRoleUpdate'))){

            Yii::$app->authManager->revokeAll($this->id);

            foreach($this->_roleList as $item){
                Yii::$app->authManager->assign(Yii::$app->authManager->getRole($item->roleName), $this->id);
			}
		}
	}

	public function beforeDelete()
	{
		if($result = parent::beforeDelete()){
			Yii::$app->authManager->revokeAll($this->id);
		}

		return $result;
	}

}
