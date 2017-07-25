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
			 
			 $data[$i]['id'] = $get[$i]['lead_id'];
			 $data[$i]['status'] = $get[$i]['lead_status'];
			 $data[$i]['main'] = $get[$i]['critical_acc'];
			 $data[$i]['name'] = $get2['name'];
			 $data[$i]['phone'] = $get2['phone'];
			 $data[$i]['city'] = $get2['city'];

			 $data[$i]['lead_date_create'] = $get[$i]['lead_date_create'];
			 $data[$i]['lead_date_close'] = $get[$i]['lead_date_close'];
			 $data[$i]['lead_date_send'] = $get[$i]['lead_date_send'];
			 $data[$i]['lead_date_delivered'] = $get[$i]['lead_date_delivered'];
			 $data[$i]['lead_date_success_delivered'] = $get[$i]['lead_date_success_delivered'];
			 $data[$i]['lead_date_reset'] = $get[$i]['lead_date_reset'];
			 $data[$i]['lead_date_reset_thing'] = $get[$i]['lead_date_reset_thing'];
			 $data[$i]['lead_summa'] = $get[$i]['lead_summa'];
			 $data[$i]['sdek_summa'] = $get[$i]['sdek_summa'];

		}
	}
	echo json_encode($data);
	//echo 1;
?>