<?php
use app\models\Ingredients;
use app\models\Features;
use app\models\Items;
$this->params['breadcrumbs'][]=['label'=>'Товары', 'url'=>'/basic/web/products'];
$this->title=$this->params['breadcrumbs'][] =$model->title;
    
echo yii\widgets\Breadcrumbs::widget([
'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'homeLink'=>[
        'label' => 'Главная ',
        'url' => Yii::$app->homeUrl,
        'title' => 'Главная',
    ]
]) ?>

<div class="product-wrap">
    <div class="i-img">
        <img src=<?= isset($model->img)?'/basic/web/'.$model->img:'https://bankers24.ru/upload/logo-projects.png' ?> alt="<?= $model->title ?>" />
    </div>
    <div class="product-info">
        <h2 class="p-text">
            <?= $model->title; ?>
        </h2>
        <p class="p-title">
            <?= $model->getAttributeLabel('type') ?>
        </p>
        <p class="p-text">
            <?= Items::types()[$model->type] ?>
        </p>
        <p class="p-title">
            <?= $model->getAttributeLabel('ingredients') ?>
        </p>
        
            <?php $ings=Features::findAll(['item'=> $model->id]);
            if (count($ings)) {
                foreach($ings as $i) {
                    $ing = Ingredients::findOne($i->ingredient);
                    echo '<p class="p-text ingr"><span class="i-name">'.$ing->title.'</span>'.$i->count.' '.$ing->dimention.'</p>';
                }
            }
            ?>
        
        <p class="p-title">
            <?= $model->getAttributeLabel('desc') ?>
        </p>
        <p class="p-text">
            <?= $model->desc ?>
        </p>
        <a href="/basic/web/products/update/<?= $model->id ?>" style="text-decoration:none"><button type="button" class="edit">
            Редактировать
        </button></a>
    </div>
</div>