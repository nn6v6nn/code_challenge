<?php

namespace app\controllers;
use app\models\Supplier;
use app\models\SupplierSearch;
use app\models\exportForm;
use yii\helpers\Url;

class SupplierController extends \yii\web\Controller
{
    public function actionIndex()
    {
		// 获取数据并根据GET参数进行筛选
		$searchModel = new SupplierSearch();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());
		
		// 记住当前地址
		Url::remember();
		
		return $this->render('index', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
		]);
    }

	public function actionExport()
    {
		// 获取记住的地址
		$lastUrl =  Url::previous();
		
		// 解析querystring
		parse_str(parse_url($lastUrl,PHP_URL_QUERY),$querystring);
		
		// 判断url的合法性
		if( !isset($querystring['r']) || 
			strpos($querystring['r'],'supplier')!= 0 ){
			return $this->goHome();
		}
		
		// 判断数据的合法性
		$searchModel = new SupplierSearch();
        if ($searchModel->load($querystring) && !$searchModel->validate()) {
			return $this->goHome();
        }
		
		// 生成导出用的表单
		$exportModel = new exportForm();
		$SupplierModel = new Supplier();
		
		// 将querystring进行序列化并传递给表单
		$supplierSearch = serialize($querystring);
		
		return $this->render('export', [
				'SupplierModel' => $SupplierModel,
				'exportModel' => $exportModel,
				'supplierSearch'=>$supplierSearch,
		]);
    }

	public function actionCsv()
    {
		// 验证导出表单的数据有效性
		$exportModel = new exportForm();
        if ($exportModel->load(\Yii::$app->request->post()) && !$exportModel->validate()) {
			return $this->goHome();
        }

		$exportFormData = \Yii::$app->request->post('exportForm');
		// 反序列化数据
		$supplierSearch = unserialize($exportFormData['supplierSearch']);
		unset($exportFormData['supplierSearch']);

		// 获取待导出的字段
		$exportFields = array_filter($exportFormData);
		$exportFieldKeys = array_keys($exportFields);

		// 根据所选字段和搜索条件提取数据
		$searchModel = new SupplierSearch();
		$dataProvider = $searchModel->search($supplierSearch,$exportFieldKeys);
		$exportData = $dataProvider->query->asArray()->all();

		// 根据导出的字段获得csv文件的标题
		$title = array_intersect_key($searchModel->attributeLabels(),$exportFields);
		
		// 输出CSV文件
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename="test.csv"');
		$output = fopen('php://output','w') or die("Can't open php://output");
		
		// UTF8 csv文件头前需添加BOM，不然会是乱码
		fwrite($output, chr(0xEF).chr(0xBB).chr(0xBF));
		
		// 输出标题行
		fputcsv($output, $title);
		
		// 输出数据内容
		foreach($exportData as $row) {
			fputcsv($output, $row);
		}
		
		fclose($output) or die("Can't close php://output");

		
    }

}
