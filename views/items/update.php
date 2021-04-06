<?php

$this->params['breadcrumbs'][]=['label'=>'Товары', 'url'=>'/basic/web/products'];
$this->params['breadcrumbs'][] = 'Редактировать '.$model->title;
$this->title='Редактировать товар';
echo yii\widgets\Breadcrumbs::widget([
'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'homeLink'=>[
        'label' => 'Главная ',
        'url' => Yii::$app->homeUrl,
        'title' => 'Главная',
    ]
]);
echo $this->render('_form', ['model'=>$model]);
?>
