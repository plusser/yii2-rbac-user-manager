<?php

namespace rbacUserManager\models;

use Yii;
use yii\base\Model;

abstract class AbstractAuthItemForm extends Model
{

    protected $model;
    protected $originalName;
    protected $_children = [];

    abstract public static function authItemTypeName(): string;

    public static function findOne($id)
    {
        return is_object($model = Yii::$app->authManager->{'get' . ucfirst(static::authItemTypeName())}($id)) ? new static($model) : null;
    }

    public function __construct($model = null, $config = [])
    {
        $this->model = $model ?? Yii::$app->authManager->{'create' . ucfirst(static::authItemTypeName())}(null);
        $this->originalName = $this->model->name;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'ruleName', 'description', ], 'trim'],
            ['name', 'required'],
            [['name', 'ruleName', ], 'string', 'min' => 2, 'max' => 255, ],
            [['description', 'children', ], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'ruleName' => 'Правило',
            'createdAt' => 'Дата создания',
            'updatedAt' => 'Дата изменения',
            'children' => 'Включает в себя',
        ];
    }

    public function getModelClass(): string
    {
        return get_class($this->model);
    }

    public function getChildren()
    {
        return (empty($this->_children) && !$this->hasErrors()) ? Yii::$app->authManager->getChildren($this->model->name) : $this->_children;
    }

    public function setChildren($children)
    {
        if(!empty($children)){
            $this->_children = [];
            foreach((array) $children as $itemName => $type){
                if(is_object($item = Yii::$app->authManager->{'get' . ($type == yii\rbac\Item::TYPE_ROLE ? 'Role' : 'Permission')}($itemName))){
                    $this->_children[$item->name] = $item;
                }
            }
        }

        return $this;
    }

    public function getId()
    {
        return $this->getName();
    }

    public function getName()
    {
        return $this->model->name;
    }

    public function setName($name)
    {
        $this->model->name = $name;

        return $this;
    }

    public function getDescription()
    {
        return $this->model->hasProperty('description') ? $this->model->description : NULL;
    }

    public function setDescription($description)
    {
        if($this->model->hasProperty('description')){
            $this->model->description = $description;
        }

        return $this;
    }

    public function getRuleName()
    {
        return $this->model->ruleName;
    }

    public function setRuleName($ruleName)
    {
        $this->model->ruleName = empty($ruleName) ? NULL : $ruleName;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->model->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->model->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->model->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->model->updatedAt = $updatedAt;

        return $this;
    }

    public function getIsNewRecord()
    {
        return empty($this->originalName);
    }

    public function validate($attributeNames = NULL, $clearErrors = true)
    {
        $result = true;

        if($this->isNewRecord || $this->name != $this->originalName){
            if(is_object(Yii::$app->authManager->getPermission($this->name)) || is_object(Yii::$app->authManager->getRole($this->name))){
                $this->addError('name', 'Разрешение или роль с таким названием уже существует.');
                $result = false;
            }
        }

        return parent::validate($attributeNames, false) && $result;
    }

    public function save()
    {
        $result = false;

        if($this->validate()){
            if($result = ($this->isNewRecord ? Yii::$app->authManager->add($this->model) : Yii::$app->authManager->update($this->originalName, $this->model))){
                Yii::$app->authManager->removeChildren($this->model);
                foreach($this->children as $item){
                    Yii::$app->authManager->addChild($this->model, $item);
                }
            }
        }

        return $result;
    }

    public function delete()
    {
        return Yii::$app->authManager->remove($this->model);
    }

}
