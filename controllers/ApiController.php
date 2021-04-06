<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Items;
use app\models\Ingredients;
use app\models\Features;
use yii\db\Query;

class ApiController extends Controller
{
    /**
     * {@inheritdoc}
     */
    /*public function behaviors()
    {
    }*/

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    public function actionProducts($id=null) {
        if (Yii::$app->request->isGet) {
            if (is_null($id)) return json_encode(Items::find()->asArray()->all());
            elseif(is_numeric($id)) return json_encode(Items::find()->where('id='.$id)->asArray()->one());
            else return 'Некоректный запрос';
        }
        if (Yii::$app->request->isPost) {
            if (is_null($id)) {
                $item = new Items;
                $item->attributes = $_POST;
                if ($item->save()) return json_encode(Items::find()->where('id='.$item->id)->asArray()->one(), JSON_UNESCAPED_UNICODE); //считываем запись из БД, а не сознанный объект item
            #return json_encode($item->attributes);
                #print_r(key($_POST));
            }
        }
        if (Yii::$app->request->isPut) {
            if (is_null($id)) return json_encode(['error'=>'Некорректный запрос']);
            elseif(is_numeric($id)) {
                $_PUT = array(); 
                  $putdata = file_get_contents('php://input'); 
                  $exploded = explode('&', $putdata);  

                  foreach($exploded as $pair) { 
                    $item = explode('=', $pair); 
                    if(count($item) == 2) { 
                      $_PUT[urldecode($item[0])] = urldecode($item[1]); 
                    } 
                  } 

                $item = Items::findOne($id);
                $item->attributes=$_PUT;
                if ($item->save()) return json_encode(Items::find()->where('id='.$id)->asArray()->one(), JSON_UNESCAPED_UNICODE); //считываем запись из БД, а не обновлённый объект item
                #echo $putdata;                
            }
            else return json_encode(['error'=>'Некорректный запрос']);
        }
        if (Yii::$app->request->isDelete) {
            if (is_null($id)) return json_encode(['error'=>'Некорректный запрос']);
            elseif(is_numeric($id)) {
                $_DELETE = array(); 
                  $deldata = file_get_contents('php://input'); 
                  $exploded = explode('&', $deldata);  

                  foreach($exploded as $pair) { 
                    $item = explode('=', $pair); 
                    if(count($item) == 2) { 
                      $_DELETE[urldecode($item[0])] = urldecode($item[1]); 
                    } 
                  } 

                $item = Items::findOne($id);
                if ($item->delete()) {
                    if (Features::deleteAll('item='.$id))
                        return json_encode(['message'=>'Операция выполнена успешно'], JSON_UNESCAPED_UNICODE); //считываем запись из БД, а не обновлённый объект item
                }
                #echo $putdata;                
            }
            else return json_encode(['error'=>'Некорректный запрос']);
            
        }
    }
    public function actionIndex()
    {
        echo 'index';
    }

}
