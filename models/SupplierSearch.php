<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SupplierSearch extends Supplier
{
    public function rules()
    {
        return [
		[['id'], 'integer'],
		[['name'],'string','max'=>50],
		[['code'],'string','max'=>3],
		[['t_status','columns'],'safe'],
        ];
    }

    public function scenarios()
    {
        // 旁路在父类中实现的 scenarios() 函数
        return Model::scenarios();
    }

    public function search($params,$fields = null)
    {
        $query = Supplier::find();
        if($fields!=null) $query->select($fields);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => 10
            ]
        ]);

        // 从参数的数据中加载过滤条件，并验证
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // 增加过滤条件来调整查询对象
        $query->andFilterWhere(['id' => $this->id])
              ->andFilterWhere(['like', 'name', $this->name])
	          ->andFilterWhere(['like', 'code', $this->code])
      	      ->andFilterWhere(['t_status'=>$this->t_status]);

        return $dataProvider;
    }
}
