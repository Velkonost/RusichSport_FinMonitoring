<?php
/**
 * Money view
 *
 * @var $this \yii\web\View
 * @var $models \app\models\Money[]
 * @var $user \app\models\User
 *
 * @var $model \app\models\Money (Inside loops)
 */

use app\models\Money;
use yii\helpers\Url;
use yii\helpers\Html;
// use app\assets\MoneyAsset;
use app\models\Payment;
// use app\components\MoneyHelper;

// MoneyAsset::register($this);

$this->registerCssFile("https://fonts.googleapis.com/css?family=Open+Sans:400,300&subset=latin,cyrillic",
	[], 'open-sans-google');
$this->title = 'Финансовый мониторинг';

$year = date('Y');
$month = date('m');
/*if (!empty($_GET['date_period'])) {
	$period = explode('-', $_GET['date_period']);
	$month = substr('0' . $period[0], -2, 2);
	$year = $period[1];
}*/



?>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?= Html::csrfMetaTags() ?>
<?php $this->head() ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<select id = "test">
	<option onclick="call();" value="Июль">Июль</option>
</select>

<form id="money-search-form" action="<?= $_SERVER['REQUEST_URI'] ?>" method="get">
	<?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []) ?>
	<div class="money-filter-container">
		<div class="fixed">
			<?php
			// echo Html::dropDownList('date_period', $month.'-'.$year, $filter['months'], [
			// 	'class'=>'form-control date-period-selector',
			// 	'data-url' => str_replace('?' . Yii::$app->getRequest()->getQueryString(), '', Yii::$app->getRequest()->getUrl())
			// ]);
			?><span class="filter-values"><?php echo $c;
				?></span><?php
			?>
			<div class="btn btn-default update_leads_btn">
				<i class="glyphicon glyphicon-refresh"></i>
			</div>
		</div>
	</div>


<div class = "no">
	
	<table id = "tableAll"style ="font-size:12px;width: 580px; border-collapse: separate;">
	<div class = "idClient" style ="margin-bottom:5px;width:550px; text-align:center; height:24px; background-color:#ffd37b;"><span>ID клиента</span></div>
		<tr>
			<td class = "tableIdClient" style ="width:102px;">Ответственный</td>
			<td class = "tableIdClient" style ="width:98px;">Имя Фамилия</td>
			<td class = "tableIdClient" style ="width:106px;">Телефон</td>
			<td class = "tableIdClient" style ="width:80px;">Город</td>
			<td class = "tableIdClient" style ="width:115px;">Статус</td>
			<td style ="font-size:14px;line-height: 1.42857143;height:50px;background-color: #fff8cc; float: left;margin-left:2.5px ;width:33.83px;">CRM</td>
		</tr>	
	</table>




<script type="text/javascript" language="javascript">
 	function call() {
        $.ajax({
          type: 'GET',
          url: '/money/getpost?date=1498867200&date2=1501545600',
          success: function(data) {
            //alert($.trim(data));
			//data = JSON.stringify(data);
			data = $.trim(data);
			data=data.slice(1, -146);
			data = $.trim(data);
			data = data.substring(1);
			data = data.substring(0, data.length - 1);

			var json_texts = data.split('},{');

			// console.log(json_texts.length);
			// console.log();
			// alert(data[0]['lead_date_create']);
			var table = document.getElementById('tableAll');
			for(var i = 0; i<json_texts.length; i++){
				data = JSON.parse("{" + json_texts[i] + "}");
				
				var elem  = document.createElement('elem'+i);
				elem.className = 'tableIdClient';
				// elem.innerHTML = data[i]['lead_date_create'];
				$('#tableAll').append('<tr>'
				+'<td style ="width:102px;" class = "tableIdClient">'+data['main']+'</td>'
				+'<td style ="width:98px;" class = "tableIdClient">'+data['name']+'</td>'
				+'<td style ="width:106px;" class = "tableIdClient">'+data['phone']+'</td>'
				+'<td style ="width:80px;" class = "tableIdClient">'+data['city']+'</td>'
				+'<td style ="width:115px;" class = "tableIdClient">'+data['status']+'</td>'
				+'<td style ="width:33.83px;" class = "tableIdClient"><a target="_blank" href="https://new584549b112ca4.amocrm.ru/leads/detail/'+data['id']+'"><img src = "/web/images/money_arr.jpg" style="max-width:100%;"/></a></td>'
				
				+'</tr>');
			}
			
			
          },
          error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
          }
        });
 
    }
</script>

<style>
.tableIdClient {
	line-height: 1.42857143;
	height:50px;
	background-color: #fff8cc; 
	float: left;margin-left:2.5px ;
	margin-top:5px;
}
</style>