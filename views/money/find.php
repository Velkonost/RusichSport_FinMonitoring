<?php
	use yii\helpers\Json;
	use yii\web\Controller;
	use app\models\Leads;
	if(!empty($_GET['date']) && !empty($_GET['date2'])){
		$date = $_GET['date'];
		$date2 = $_GET['date2'];

		$get = Yii::$app->db->createCommand("SELECT * FROM contacts 
				WHERE `name` LIKE '%$_GET[contact_name]%'
				AND `phone` LIKE '%$_GET[phone]'
				AND `city` LIKE '%$_GET[city]%'
				")->queryAll();

		// $get = Yii::$app->db->createCommand("SELECT * FROM leads 
		// 	WHERE `critical_acc` LIKE '%$_GET[critical_acc]%'
		// 	AND `

		// 	ORDER BY lead_date_create DESC")
		// ->queryAll();
		$data = [];
		//echo 1;
		$g = 0;

		/*

		SELECT * 
FROM  `leads` 
WHERE  `critical_acc` LIKE  '%о%'
ORDER BY  `id` ASC 
LIMIT 0 , 30

		*/
		//echo $date;
		for($i = 0; $i<count($get); $i++){
			$id = $get[$i]['contact_id'];
			// if($get[$i]['lead_date_create']>=$date && $get[$i]['lead_date_create']<=$date2){
				 // $get2 = Yii::$app->db->createCommand("SELECT * FROM contacts WHERE contact_id = '$id'")
					// ->queryOne();
				 
				 $data[$g]['id'] = $get[$i]['contact_id'];
				 $data[$g]['name'] = $get[$i]['name'];
				 $data[$g]['phone'] = $get[$i]['phone'];
				 $data[$g]['city'] = $get[$i]['city'];

				 // $data[$g]['status'] = $get[$i]['lead_status'];
				 // $data[$g]['main'] = $get[$i]['critical_acc'];
				 // $data[$g]['name'] = $get2['name'];
				 // $data[$g]['phone'] = $get2['phone'];
				 // $data[$g]['city'] = $get[$i]['city'];
				 // $data[$g]['lead_date_create'] = $get[$i]['lead_date_create'];
				 // $data[$g]['lead_date_close'] = $get[$i]['lead_date_close'];
				 // $data[$g]['lead_date_send'] = $get[$i]['lead_date_send'];
				 // $data[$g]['lead_date_delivered'] = $get[$i]['lead_date_delivered'];
				 // $data[$g]['lead_date_success_delivered'] = $get[$i]['lead_date_success_delivered'];
				 // $data[$g]['lead_date_reset'] = $get[$i]['lead_date_reset'];
				 // $data[$g]['lead_date_reset_thing'] = $get[$i]['lead_date_reset_thing'];
				 // $data[$g]['lead_summa'] = $get[$i]['lead_summa'];
				 // $data[$g]['sdek_summa'] = $get[$i]['sdek_summa'];
				 $g++;
			// }
		}
		echo json_encode($data);
	}
?>