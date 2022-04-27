<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use app\models\Supplier;
use yii\widgets\ActiveForm;

$this->title = '厂商 - 数据导出';
$this->params['breadcrumbs'][] = ['label' => '厂商' ,'url'=> ['/supplier/index']];
$this->params['breadcrumbs'][] = '数据导出';

echo html::tag('h5','请选择要导出的列');

$form = ActiveForm::begin([
    'id' => 'export-form',
    'action'=>'?r=supplier/csv',
    'options' => ['class' => 'form-horizontal'],
]);

$labels = $SupplierModel->attributeLabels();

echo $form->field($exportModel,'id')->checkbox(['label'=>$labels['id'],'checked' => true, 'required' => true]);
echo $form->field($exportModel,'name')->checkbox(['label'=>$labels['name']]);
echo $form->field($exportModel,'code')->checkbox(['label'=>$labels['code']]);
echo $form->field($exportModel,'t_status')->checkbox(['label'=>$labels['t_status']]);

echo $form->field($exportModel, 'supplierSearch')->hiddenInput(['value'=> $supplierSearch])->label(false);

echo Html::submitButton('确认', ['class' => 'btn btn-primary']) ;

ActiveForm::end()
/* @var $this yii\web\View */
?>

