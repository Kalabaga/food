<?php
use app\models\Ingredients;
use app\models\Items;
use yii\widgets\LinkPager;

$type = Items::types();
#$items = Items::findAll();
/* @var $this yii\web\View */
$req = Yii::$app->request;
$this->title = 'Список товаров';
$pageCSS='';
#var_dump($items);
?>
<div class="site-index">
    <table class="item-list">
        <h1>
            Список товаров
        </h1>
        <div class="toolbar">
            <a class="btn create" href="/basic/web/products/create">Новый</a>
            <input class="search" placeholder="Поиск">
        </div>
        <tr class="t-head">
            <th>Название</th>
            <th>Тип</th>
            <th class="ui"></th>
</tr>
 <?php foreach($items as $i) { ?>
        <tr id = "i<?= $i['id'] ?>">
            <td><a href="/basic/web/products/<?= $i['id'] ?>" ><?= $i['title'] ?></a></td>
            <td><?php echo $type[$i['type']] ?></td>
            <td class="ui">
                <button class="update"><a href="products/update/<?= $i['id'] ?>" ></a>
                </button>
                <!--button class="view"><a href="products/<?= $i['id'] ?>" ></a>
                </button-->
                <button class="delete">
                </button>
            </td>
        </tr>
<? }
        ?>
       
    </table>
    <div class="pagination-wrap">
       <?= LinkPager::widget(['pagination'=>$pages]); ?>
        
    </div>
    
</div>
