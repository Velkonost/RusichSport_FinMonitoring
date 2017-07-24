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
			echo Html::dropDownList('date_period', $month.'-'.$year, $filter['months'], [
				'class'=>'form-control date-period-selector',
				'data-url' => str_replace('?' . Yii::$app->getRequest()->getQueryString(), '', Yii::$app->getRequest()->getUrl())
			]);
			?><span class="filter-values"><?php echo $c;
				?></span><?php
			?>
			<div class="btn btn-default update_leads_btn">
				<i class="glyphicon glyphicon-refresh"></i>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="money-layout">
		<div style="display:none;" class="money-abs-header js-money-abs-header"></div>
		<div class="money-table-clients money-abs-clients-header"></div>
		<div class="money-table-clients money-abs-clients js-money-abs-clients"></div>
	</div>
	<div class="clearfix"></div>
	<div class="money-layout js-money-layout-real">
		<div class="money-table money-table-clients js-money-table-clients">
			<div class="money-table-row money-table-row-title js-money-table-row-title" data-class="money-table-clients">
				<div class="money-table-cell">ID клиента</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header">
				<div class="money-table-cell">Ответственный</div>
				<div class="money-table-cell">Имя Фамилия</div>
				<div class="money-table-cell">Телефон</div>
				<div class="money-table-cell">Город</div>
				<div class="money-table-cell">Статус</div>
				<div class="money-table-cell small-paddings">CRM</div>
			</div>
		

		<div class="money-table-rows js-money-table-rows">
				<?php // for ($i = 0; $i < $amount; $i++) { ?>
					<div class="money-table-row money-table-row-data money-item-<?php //echo $model->id ?> <?php //echo ($k%2==0) ? 'row-even' : 'row-odd' ?>" data-id="<?php //echo $model->id ?>">
						<div class="money-table-cell">
							<div class="money-table-long-data money-column-client_menedger"><!-- don't replace "_" in client_name it's special field marker -->

							Ответственный
								<!-- <?php //if(isset($manager[$model->responsible_user_id])) { ?>
									<?php  //$manager[$model->responsible_user_id] ?>
								<?php //} ?> -->
							</div>
						</div>
						<div class="money-table-cell">
							<div class="money-table-long-data money-column-client_name"><!-- don't replace "_" in client_name it's special field marker -->
								<?php //echo $names[$i] ?>
							</div>
						</div>
						<div class="money-table-cell money-column-phone"><?=$phones[$i] ?></div>
						<div class="money-table-cell">
							<div class="money-table-long-data money-column-city">Город</div>
						</div>
						<div class="money-table-cell small-paddings">
						<?php //echo $dates[$i]?>
							<!-- <?php
						/*	if ($model->status) {
								echo '<span class="status-label" style="background-color: ' . $model->status->color . ';">'
									. $model->status->label . '</span>';
							} else {
								echo '---';
							}*/
							?> -->
						</div>
						<div class="money-table-cell">
							<a href="https://new584549b112ca4.amocrm.ru/leads/detail/<?= $ids[$i]; ?>" title="Перейти в сделку AMOCRM" target="_blank">
								<img src="/web/images/money_arr.png">
							</a>
						</div>
					</div>
				<?php // } ?>
				<div class="money-table-row money-total-row">
					<div class="money-table-cell">&nbsp;</div>
				</div>
				<div class="money-table-row money-total-row">
					<div class="money-table-cell">&nbsp;</div>
				</div>
				<div class="money-table-row money-total-row">
					<div class="money-table-cell">&nbsp;</div>
				</div>
			</div>

</div>

		
		
		
	
<div class="modal" id="comment-modal" data-id="0">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Комментарий</h4>
			</div>
			<div class="modal-body">
				<textarea id="comment_textarea"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-primary save-btn">Сохранить</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal" id="comment-fin-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Комментарий</h4>
			</div>
			<div class="modal-body">
				<span id="comment_fin_text"></span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript" language="javascript">
 	function call() {
        $.ajax({
          type: 'GET',
          url: 'index.php?r=money/getpost&date=1498867200&date2=1501545600',
          success: function(data) {
            //alert($.trim(data));
			//data = JSON.stringify(data);
			data = data.replace(' ','');
			alert(data);
          },
          error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
          }
        });
 
    }
</script>