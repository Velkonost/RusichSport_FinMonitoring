<?php
	use yii\helpers\Html;
	use yii\helpers\Json;
	use yii\web\Controller;
	use yii\web\NotFoundHttpException;
	use yii\filters\AccessControl;
	use yii\filters\VerbFilter;
	use app\models\Leads;
	$date = $_GET['date'];
	$get = Yii::$app->db->createCommand("SELECT * FROM leads WHERE lead_date_	create > '$date'")
		->queryAll();
	echo $date;
	echo var_dump($get);
?>