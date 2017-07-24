<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$pageId = Yii::$app->controller->id . '-' . Yii::$app->controller->action->id;
$controller = Yii::$app->controller->id;
$user = Yii::$app->user->identity;

?>
<?php $this->beginPage() ?>


<?php $this->beginBody() ?>

        <?php
        if ($controller == 'user') {
            echo Breadcrumbs::widget([
                'homeLink' => false,
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]);
        }
        ?>

        <?= $content ?>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
