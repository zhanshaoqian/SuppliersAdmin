<?php


namespace app\models;

use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

class Supplier extends ActiveRecord
{
    public $ids;

    public function rules()
    {
        return [
            [['id', 'name', 'code', 't_status'], 'trim'],
            ['id', 'integer'],
            ['name', 'string'],
        ];
    }

    public function search($params)
    {
        $query = self::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
                'pageParam' => 'p',
                'pageSizeParam' => 'pageSize',
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
                'attributes' => [
                    'id',
                    'name',
                    'code',
                    't_status'
                ],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $provider;
        }

        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['code' => $this->code])
            ->andFilterWhere(['t_status' => $this->t_status]);

        return $provider;
    }
}