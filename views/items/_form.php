<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\Ingredients;
use app\models\Features;
use app\models\Items;
use yii\db\ActiveRecord;
$form = ActiveForm::begin();
$ingredients=$dimentions=[];
foreach(Ingredients::find()->asArray()->all() as $ing) {
    $ingredients[$ing['id']]=$ing['title'];
    $dimentions[$ing['id']]=$ing['dimention'];
}
$ingredients[0]='';
ksort($ingredients);
?>

<div class="product-wrap">
    <div class="i-img">
        <img src="<?= isset($model->img)?'/basic/web/'.$model->img:'https://bankers24.ru/upload/logo-projects.png' ?>" alt="<?= $model->title ?>" />
        <div class="buttonsImg">
        <?= Html::button('Выбрать', ['id'=>'selectImg']) ?>
        <!--?= Html::activeFileInput($model, 'img') ?-->
            <?= $form->field($model, 'img')->fileInput() ?>
            
        </div>
        
    </div>
    <div class="product-info">
        <?= Html::activeLabel($model, 'title'); ?>
        <?= Html::activeTextInput($model, 'title'); ?>
        <?= Html::activeLabel($model, 'type'); ?>
        <?= Html::activeDropDownList($model, 'type', Items::types()) ?>
        <?= Html::activeLabel($model, 'ingredients'); ?>
        <div class="ingredients">
            <?php $ings=Features::findAll(['item'=>$model->id]);
            if (count($ings)) {
                foreach($ings as $i) { 
                
            ?>
            <div class="ingredient">
                <?= Html::activeDropDownList($i, 'ingredient', $ingredients, ['id'=>'features-ingredient_'.$i->id, 'name'=>'Features[ingredient][]']) ?>
                <?= Html::activeHiddenInput($i, 'id', ['name'=>'Features[id][]']); ?>
                <?= Html::activeTextInput($i, 'count', ['class'=>'count', 'name'=>'Features[count][]']).' <span class="diment">'.Ingredients::findOne($i->ingredient)->dimention.'</span>' ?> 
                <?= Html::button('', ['class'=>'del-ing']) ?>
            </div>
                    
                <? }
            } ?>
            <div class="ingredient">
                <?= Html::activeDropDownList(new Features, 'ingredient', $ingredients, ['id'=>'features-ingredient', 'name'=>'']) ?>
                <?= Html::activeTextInput(new Features, 'count', ['class'=>'count', 'name'=>'']) ?> 
                <span class="diment"></span>
                <?= Html::button('', ['class'=>'add-ing']) ?>
            </div>
            
        </div>
        <?= Html::button('Добавить новый ингредиент', ['class'=>'add-ing-new']) ?>
        <?= Html::activeLabel($model, 'desc'); ?>
            <?= Html::activeTextarea($model, 'desc') ?>
        <?= Html::submitButton('Сохранить') ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<script>
    var $dimentions=<?= json_encode($dimentions) ?>
</script>