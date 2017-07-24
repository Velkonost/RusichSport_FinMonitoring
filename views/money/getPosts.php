<?php
	use yii\helpers\Html;
	use yii\helpers\Json;
	use yii\web\Controller;
	use yii\web\NotFoundHttpException;
	use yii\filters\AccessControl;
	use yii\filters\VerbFilter;
	use app\models\Leads;
	$date = $_GET['date'];
	$date2 = $_GET['date2'];
	$get = Yii::$app->db->createCommand("SELECT * FROM leads ORDER BY lead_date_create DESC")
    ->queryAll();
	$data = [];
	//echo $date;
	for($i = 0; $i<count($get); $i++){
		if($get[$i]['lead_date_create']>=$date && $get[$i]['lead_date_create']<=$date2){
			 $data[$i]['contact_name'] = $get[$i]['contact_name'];
			 $data[$i]['lead_date_create'] = date("d.m.Y h:m:s",$get[$i]['lead_date_create']);
		}
	}
	echo json_encode($data);
	//echo 1;
?>