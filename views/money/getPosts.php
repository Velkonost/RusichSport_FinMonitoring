<?php
	use yii\helpers\Json;
	use yii\web\Controller;
	use app\models\Leads;
	$date = $_GET['date'];
	$date2 = $_GET['date2'];
	$get = Yii::$app->db->createCommand("SELECT * FROM leads ORDER BY lead_date_create DESC")
    ->queryAll();
	$data = [];
	//echo 1;
	//echo $date;
	for($i = 0; $i<count($get); $i++){
		$id = $get[$i]['contact_id'];
		if($get[$i]['lead_date_create']>=$date && $get[$i]['lead_date_create']<=$date2){
			 $get2 = Yii::$app->db->createCommand("SELECT * FROM contacts WHERE contact_id = '$id'")
				->queryOne();
			 
			 $data[$i]['status'] $get[$i]['lead_status'];
			 $data[$i]['main'] $get[$i]['critical_acc'];
			 $data[$i]['name'] = $get2['name'];
			 $data[$i]['phone'] = $get2['phone'];
			 $data[$i]['city'] = $get2['city'];
		}
	}
	echo json_encode($data);
	//echo 1;
?>