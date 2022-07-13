<?php 

namespace rbacUserManager\components;

use Yii;
use yii\data\ArrayDataProvider;
use yii\data\DataProviderInterface;

trait AuthItemSearchTrait
{

    public function rules()
    {
        return [
            [['name', 'description', 'ruleName', 'createdAt', 'updatedAt'], 'safe'],
            [['name', 'description', 'ruleName', 'createdAt', 'updatedAt'], 'trim'],
        ];
    }

    public function getRulesFilter(): array
    {
        $result = [];

        foreach(Yii::$app->authManager->getRules() as $item){
            $result[$item->name] = $item->name;
        }

        return $result;
    }

    public function search(array $params): DataProviderInterface
    {
        $this->load($params);
        $this->validate();

        $modelClass = $this->getModelClass();
        $allModels = [];

        foreach($this->getDataList() as $item){
            $conditions = [];

            if($this->name != ''){
                $conditions['name'] = mb_strripos($item->name, $this->name) !== false;
            }

            if($this->description != ''){
                $conditions['description'] = mb_strripos($item->description, $this->description) !== false;
            }

            if($this->ruleName != ''){
                $conditions['ruleName'] = $item->ruleName == $this->ruleName;
            }

            if($this->createdAt != ''){
                $conditions['createdAt'] = date('Y-m-d', $item->createdAt) == date('Y-m-d', strtotime($this->createdAt));
            }

            if($this->createdAt != ''){
                $conditions['createdAt'] = date('Y-m-d', $item->createdAt) == date('Y-m-d', strtotime($this->createdAt));
            }

            if(array_sum($conditions) == count($conditions)){
                $allModels[$item->name] = new $modelClass($item);
            }
        }

        return new ArrayDataProvider([
            'allModels' => $allModels,
            'pagination' => [
                'pageSize' => Yii::$app->controller->module->paginationPageSize,
            ],
            'sort' => [
                'attributes' => ['name', 'description', 'ruleName', 'createdAt', 'updatedAt', ],
            ],
        ]);
    }

    abstract public function getModelClass(): string;
    abstract protected function getDataList(): array;

}
