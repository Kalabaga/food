<?php

$this->params['breadcrumbs'][]=['label'=>'Товары', 'url'=>'/basic/web/products'];
$this->title=$this->params['breadcrumbs'][] ='Новый товар';
echo yii\widgets\Breadcrumbs::widget([
'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'homeLink'=>[
        'label' => 'Главная ',
        'url' => Yii::$app->homeUrl,
        'title' => 'Главная',
    ]
]);
echo $this->render('_form', ['model'=>new app\models\Items]);
?>
