<?php
use app\models\Ingredients;
use app\models\Items;
use yii\data\Pagination;
use yii\widgets\LinkPager;

$type = Items::types();
$items = Items::find()->all();
$it=[];
foreach($items as $key=>$i) {
    $it[$i->id]=$i->id.':'.$i->title;
}
/* @var $this yii\web\View */
$req = Yii::$app->request;
$this->title = 'Главная';
$pageCSS='';
?>
<div class="site-index">
        <a href="products">
            Список товаров
        </a>
    
</div>
<div class="stand">
    <h2>
        Игровой стенд
    </h2>
    <div class="board">
        <div class="command-row">
            <p class="title">
                Вывод списка (с пагинацией)
            </p>
            <div class="code">
                <a href="api/products" target="_blank">GET: /api/products</a>
            </div>
        </div>
        <div class="command-row">
             <p class="title">
                Запрос данных по id
            </p>
            <div class="code">
                <a href="api/products/1" target="_blank">GET: /api/products/1</a>
            </div>
           
        </div>
        <div class="command-row">
             <p class="title">
                Создание новой записи
            </p>
            <div class="code">
                <p>
                    POST: /api/products
                </p>
                <textarea>title=Новый товар&type=5&desc=Примечание</textarea>
                <span class="request" id="post-create"></span>
                <button id="create">Отправить</button>
            </div>
            
        </div>
        <div class="command-row">
             <p class="title">
                Редактирование записи
            </p>
            <div class="code">
                <p>
                    PUT: /api/products/1
                </p>
                <p>
                    Текущее значение: <span id="updateNow"></span>
                </p>
                <script>
                   $.ajax({
                        url:'api/products/1',
                        type: 'GET',
                       dataType: 'json',
                   }).done(function(e) {
                        $('#updateNow').text(JSON.stringify(e));
                    });
                </script>
                <textarea>&title=Булочка&type=1&desc=С кунжутом</textarea>
                <span class="request" id="post-update"></span>
                <button id="update">Отправить</button>
            </div>            
        </div>
        <div class="command-row">
             <p class="title">
                Удаление записи
            </p>
            <div class="code">
                <p>
                    DELETE: /api/products/<?= yii\helpers\Html::dropDownList('items-list', 0, $it, ['id'=>'items-list']) ?>
                </p>
                <span class="request" id="delete-del"></span>
                <button id="delete">Отправить</button>
            </div>            
            
        </div>
    </div>
</div>
