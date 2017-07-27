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

<select onchange="call();" id = "months">

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


<div class = "idClient" style ="display:inline-block;margin-bottom:5px;width:550px; text-align:center; height:24px; background-color:#ffd37b;"><span>ID клиента</span></div>
<div class = "no">
	<table id = "tableAll"style ="background-color: #ffffff;display:inline-block;font-size:12px;width: 550px; border-collapse: separate;">
		<tr>
			<td class = "tableIdClient" style ="line-height: 1.42857143; background-color: #fff8cc; float: left;margin-left:2.5px ;font-size: 12px; width:102px;">Ответственный</td>
			<td class = "tableIdClient" style ="line-height: 1.42857143; background-color: #fff8cc; float: left;margin-left:2.5px ;font-size: 12px;width:98px;">Имя Фамилия</td>
			<td class = "tableIdClient" style ="line-height: 1.42857143; background-color: #fff8cc; float: left;margin-left:2.5px ;font-size: 12px;width:106px;">Телефон</td>
			<td class = "tableIdClient" style ="line-height: 1.42857143; background-color: #fff8cc; float: left;margin-left:2.5px ;font-size: 12px;width:80px;">Город</td>
			<td class = "tableIdClient" style ="line-height: 1.42857143; background-color: #fff8cc; float: left;margin-left:2.5px ;font-size: 12px;width:115px;">Статус</td>
			<td style ="margin-top: 5px;font-size:14px;line-height: 1.42857143;height:50px;background-color: #fff8cc; float: left;margin-left:2.5px ;width:33.83px;">CRM</td>
		</tr>	
	</table>
</div>



<script type="text/javascript" language="javascript">
	startCall();
	
 	function call() {
		var val1 = (document.getElementById('months').value);
		var val2 = "";
		var val3 = val1.slice(0, -5);
		var date2 = ""
		switch(val3){
			case "Январь":
				val2 = val1.slice(7, 11);
				val3 = "01";
				date2 = "31";
				break;
			case "Февраль":
				val3 = "02";
				val2 = val1.slice(8, 12);
				if(Number(val2)%4 == 0){
					date2 = "29";
				}else{
					date2 = "28";
				}
				break;
			case "Март":
				val3 = "03";
				val2 = val1.slice(5, 9);
				date = "31";
				break;
			case "Апрель":
				val3 = "04";
				val2 = val1.slice(7, 11);
				date = "30";
				break;
			case "Май":
				val3 = "05";
				val2 = val1.slice(4, 8);
				date = "31";
				break;
			case "Июнь":
				val3 = "06";
				val2 = val1.slice(5, 9);
				date = "30";
				break;
			case "Июль":
				val3 = "07";
				val2 = val1.slice(5, 9);
				date = "31";
				break;
			case "Август":
				val3 = "08";
				val2 = val1.slice(7, 11);
				date = "31";
				break;
			case "Сентябрь":
				val3 = "09";
				val2 = val1.slice(9, 13);
				date = "30";
				break;
			case "Октябрь":
				val3 = "10";
				val2 = val1.slice(8, 12);
				date = "31";
				break;
			case "Ноябрь":
				val2 = val1.slice(7, 11);
				val3 = "11";
				date = "30";
				break;
			case "Декабрь":
				val2 = val1.slice(8, 12);
				val3 = "12";
				date = "31";
				break;
		}
		var fulldate = "01-"+val3+"-"+val2;
		var fulldate2 = date+"-"+val3+"-"+val2;
		fulldate = fulldate.split("-");
		fulldate2 = fulldate2.split("-");
		
		fulldate =  new Date(fulldate[1]+"/"+fulldate[0]+"/"+fulldate[2]).getTime()/1000;
		fulldate2 =   new Date(fulldate2[1]+"/"+fulldate2[0]+"/"+fulldate2[2]).getTime()/1000;
		
        $.ajax({
          type: 'GET',
          url: '/money/getpost?date='+fulldate+'&date2='+fulldate2,
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
			while(table.rows[1]) table.deleteRow(1);
			
			
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
				+'<td style ="width:33.83px;" class = "tableIdClient"><a target="_blank" href="https://new584549b112ca4.amocrm.ru/leads/detail/'+data['id']+'"><img src = "../web/img/money_arr.png" style="max-width:100%;"/></a></td>'
				
				+'</tr>');
			}
			
			
          },
          error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
          }
        });
 
    }
	
	function startCall() {
        $.ajax({
          type: 'GET',
          url: '/money/getpost',
          success: function(data) {
            //alert($.trim(data));
			//data = JSON.stringify(data);
			data = $.trim(data);
			data = data.slice(1, -146);
			data = $.trim(data);
			data = data.substring(1);
			data = data.substring(0, data.length - 1);
			
			var json_texts = data.split('},{');
			
			var month = [];
			
			var selectMonths = document.getElementById('months');
			//alert(data.length);
			//console.log(json_texts);
			for(var i = 0; i<json_texts.length; i++){
				//console.log(json_texts[i]);
				data = JSON.parse("{" + json_texts[i] + "}");
				switch(data['month']){
					case "01":
						var opt = document.createElement('option');
						opt.innerHTML = 'Январь '+data['year'];
						opt.value = 'Январь '+data['year'];
						$('#months').append(opt);
						break;
					case "02":
						var opt = document.createElement('option');
						opt.innerHTML = 'Февраль '+data['year'];
						opt.value = 'Февраль '+data['year'];
						$('#months').append(opt);
						break;
					case "03":
						var opt = document.createElement('option');
						opt.innerHTML = 'Март '+data['year'];
						opt.value = 'Март '+data['year'];
						$('#months').append(opt);
						break;
					case "04":
						var opt = document.createElement('option');
						opt.innerHTML = 'Апрель '+data['year'];;
						opt.value  = 'Апрель '+data['year'];
						$('#months').append(opt);
						break;
					case "05":
						var opt = document.createElement('option');
						opt.innerHTML = 'Май '+data['year'];
						opt.value = 'Май '+data['year'];
						$('#months').append(opt);
						break;
					case "06":
						var opt = document.createElement('option');
						opt.innerHTML =  'Июнь '+data['year'];
						opt.value =  'Июнь '+data['year'];
						$('#months').append(opt);
						break;
					case "07":
						var opt = document.createElement('option');
						opt.innerHTML = 'Июль '+data['year'];
						opt.value =  'Июль '+data['year'];
						$('#months').append(opt);
						break;
					case "08":
						var opt = document.createElement('option');
						opt.innerHTML ='Август '+data['year'];
						opt.value = 'Август '+data['year'];
						$('#months').append(opt);
						break;
					case "09":
						var opt = document.createElement('option');
						opt.innerHTML = 'Сентябрь '+data['year'];
						opt.value = 'Сентябрь '+data['year'];
						$('#months').append(opt);
						break;
					case "10":
						var opt = document.createElement('option');
						opt.innerHTML = 'Октябрь '+data['year'];
						opt.value ='Октябрь '+data['year'];
						$('#months').append(opt);
						break;
					case "11":
						var opt = document.createElement('option');
						opt.innerHTML ='Ноябрь '+data['year'];
						opt.value ='Ноябрь '+data['year'];
						$('#months').append(opt);
						break;
					case "12":
						var opt = document.createElement('option');
						opt.innerHTML ='Декабрь '+data['year'];
						opt.value = 'Декабрь '+data['year'];
						$('#months').append(opt);
						break;
				}
			}
			
			call();
			// console.log(json_texts.length);
			
			// alert(data[0]['lead_date_create']);
			
			
			
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