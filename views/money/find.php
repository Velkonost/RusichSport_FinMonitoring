<?php
	if(!empty($_GET['date']) && !empty($_GET['date2']) && !empty($_GET['type']) && !empty($_GET['word'])){
		$date = $_GET['date'];
		$date2 = $_GET['date2'];
		
		//echo $date;
		$type = $_GET['type'];
		$get = Yii::$app->db->createCommand("SELECT '$type' FROM leads ORDER BY lead_date_create DESC")
		->queryAll();
		$data = [];
		//echo 1;
		$g = 0;
		//echo $date;
		for($i = 0; $i<count($get); $i++){
			
			$id = $get[$i]['contact_id'];
			if($get[$i]['lead_date_create']>=$date && $get[$i]['lead_date_create']<=$date2){
				 $get2 = Yii::$app->db->createCommand("SELECT * FROM contacts WHERE contact_id = '$id'")
					->queryOne();
				 $id = $get[$i]['contact_id'];
				 switch($type){
					 case "name":
						$names = [];
						$g = 0;
						$get2 = Yii::$app->db->createCommand("SELECT * FROM contacts WHERE contact_id = '$id'")
							->queryAll();
						for($k = 0; $k<count($get2); $k++){
							if(strripos($get2['name'], $_GET['word'])==false){
								
							}else{
								
							}
						}
						break;
					 
				 }

			}
		}
	}




?>