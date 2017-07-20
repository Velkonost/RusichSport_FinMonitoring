<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php if ($name) { ?><p>Вы ввели имя <b><?=$name?></b>.</p><?php } ?>
<?php $f = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<?=$f->field($form, 'name') ?>
	<?=$f->field($form, 'email') ?>
	<?=$f->field($form, 'file')->fileInput() ?>
	<?= Html::submitButton('Send'); ?>

<?php ActiveForm::end(); ?>