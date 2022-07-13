<?php 

namespace rbacUserManager\models;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\data\DataProviderInterface;
use crud\interfaces\SearchModelInterface;

class RuleSearch extends Model implements SearchModelInterface
{

    protected $model;

    public function __construct($model = null, $config = [])
    {
        $this->model = $model ?? (object)array_fill_keys(array_keys($this->attributeLabels()), NULL);

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'description', 'modelClass', 'createdAt', 'updatedAt'], 'safe'],
            [['name', 'description', 'modelClass', 'createdAt', 'updatedAt'], 'trim'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'modelClass' => 'Класс',
            'createdAt' => 'Дата создания',
            'updatedAt' => 'Дата изменения',
        ];
    }

    public function search(array $params): DataProviderInterface
    {
        $this->load($params);

        $allModels = [];

        foreach(Yii::$app->authManager->getRules() as $item){
            $conditions = [];

            if($this->name != ''){
                $conditions['name'] = mb_strripos($item->name, $this->name) !== false;
            }

            if($this->description != ''){
                $conditions['description'] = mb_strripos($item->description, $this->description) !== false;
            }

            if($this->modelClass != ''){
                $conditions['modelClass'] = mb_strripos(get_class($item), $this->modelClass) !== false;
            }

            if($this->createdAt != ''){
                $conditions['createdAt'] = date('Y-m-d', $item->createdAt) == date('Y-m-d', strtotime($this->createdAt));
            }

            if($this->createdAt != ''){
                $conditions['createdAt'] = date('Y-m-d', $item->createdAt) == date('Y-m-d', strtotime($this->createdAt));
            }

            if(array_sum($conditions) == count($conditions)){
                $allModels[$item->name] = new static($item);
            }
        }



        return new ArrayDataProvider([
            'allModels' => $allModels,
            'pagination' => [
                'pageSize' => Yii::$app->controller->module->paginationPageSize,
            ],
            'sort' => [
                'attributes' => ['name', 'description', 'modelClass', 'createdAt', 'updatedAt', ],
            ],
        ]);
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
        return $this->model->description ?? NULL;
    }

    public function setDescription($description)
    {
        $this->model->description = $description;

        return $this;
    }

    public function getModelClass()
    {
        return ($modelClass = get_class($this->model)) == 'stdClass' ? $this->model->modelClass : $modelClass;
    }

    public function setModelClass($modelClass)
    {
        $this->model->modelClass = $modelClass;

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

}
