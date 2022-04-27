<?php

namespace app\models;

use Yii;

class exportForm extends \yii\base\Model
{
    public $supplierSearch;
    public $id = 1;
    public $name = 1;
    public $code = 1;
    public $t_status = 1;


    public function rules()
    {
        return [
            [['id'],'required','requiredValue'=>1 ,'message'=>"ID必须选中"],
        ];
    }
}