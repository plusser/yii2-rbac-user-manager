<?php

namespace rbacUserManager\models;

use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use crud\interfaces\SearchModelInterface;

class UserSearch extends User implements SearchModelInterface
{

    public function rules()
    {
        return [
            [['id', 'username', 'email', 'status', 'created_at', 'updated_at'], 'safe'],
            [['id', 'username', 'email', 'status', 'created_at', 'updated_at'], 'trim'],
        ];
    }

    public function search(array $params): DataProviderInterface
    {
        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $this->validate();

        if($this->validate()){
            $query->andFilterWhere(['id' => $this->id])
                ->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['status' => $this->status]);

            if($this->created_at){
                $query->andWhere('FROM_UNIXTIME(created_at, \'%Y-%m-%d\') = :created_at', [':created_at' => date('Y-m-d', strtotime($this->created_at))]);
            }

            if($this->updated_at){
                $query->andWhere('FROM_UNIXTIME(updated_at, \'%Y-%m-%d\') = :updated_at', [':updated_at' => date('Y-m-d', strtotime($this->updated_at))]);
            }
        }

        return $dataProvider;
    }

}
