<?php

use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use app\models\Supplier;
use yii\widgets\ActiveForm;


$this->title = '厂商 - 列表';
$this->params['breadcrumbs'][] = ['label' => '厂商' ,'url'=> ['/supplier/index']];
$this->params['breadcrumbs'][] = '列表';

$gridViewColumns = [
    ['class' => 'yii\grid\CheckboxColumn'],
    'id',
    'name',
    'code',
    [
        'attribute' => 't_status',
	    'filter' => ['ok' => 'ok', 'hold' => 'hold'],
	    'filterInputOptions' => [
      		'class' => 'form-control',         
    	   'prompt' => 'Select Option'
    	],
    ],
];


//导出按钮，如果有可供导出的数据，按钮可以使用，否则设为禁用
if($dataProvider->getTotalCount()){
    echo Html::a('导出全部结果', ['supplier/export'], ['class'=>'btn btn-primary']);
}else{
    echo Html::tag('button','导出全部结果',['class'=>'btn btn-secondary ','disabled'=>true]);
}

echo html::tag('div','&nbsp;',['class'=>'clearfix']);

echo GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
    'columns' => $gridViewColumns,
    'pager' => [
        'firstPageLabel' => '首页',
        'prevPageLabel' => '上一页',
        'nextPageLabel' => '下一页',
        'lastPageLabel' => '末页',
    ]
]);
// ActiveForm::end()
/* @var $this yii\web\View */
?>

