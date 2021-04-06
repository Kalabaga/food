<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
#use yii\bootstrap\Nav;
#use yii\bootstrap\NavBar;
#use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <?php $this->head();
if (isset($this->pageCSS)) {
    if (gettype($this->pageCSS)=='array') {
        foreach($this->pageCSS as $css) { ?>
            	<link rel="stylesheet" type="text/css" href="<?php echo CHtml::encode($css)."?".rand(); ?>" />

       <? } 
    }
    elseif (isset($this->pageCSS) and !empty($this->pageCSS)) { ?>
	<link rel="stylesheet" type="text/css" href="<?php echo CHtml::encode($this->pageCSS)."?".rand(); ?>" />
<? }} ?>
<script src='<?= Yii::$app->request->baseUrl ?>/js/j7.js'></script>    
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container">
        
        <?= $content ?>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
