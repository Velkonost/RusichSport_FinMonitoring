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
	$get = Yii::$app->db->createCommand("SELECT * FROM leads WHERE lead_date_create BETWEEN '$date' AND 'date2'")
		->queryAll();
	echo $date;
	echo var_dump($get);
?>