<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Items;
use app\models\Features;
use app\models\Ingredients;
use yii\data\Pagination;
use yii\web\UploadedFile;

#use yii\web\NotFoundHttpException;


class ItemsController extends Controller
{


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $models=Items::all(); //модели как массив
        $pages=new Pagination(['totalCount'=>$models->count(), 'pageSize'=>'10']);
        $models=$models->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', ['items'=>$models, 'pages'=>$pages]);
    }
    public function actionView($id) {
        $model=Items::findOne($id);
        return $this->render('view', ['model'=>$model]);
        #var_dump($model);
    }
    public function actionUpdate($id) {
        $model=Items::findOne($id);
        if (Yii::$app->request->isPost) {
            if(isset($_POST['Items'])) {
                $model->attributes=$_POST['Items'];
                
                if($_FILES['Items']['error']['img']==0) {
                    $model->imageFile = UploadedFile::getInstance($model, 'img');
                    $a=$model->upload();
                    if(gettype($a)=='string') $model->img=$a;
                  
                }
                else unset($model->img);
            }
            if (isset($_POST['Ingredients'])) {
                #die(json_encode($_POST));
                        if(isset($_POST['Features']['ingredient']))
                        $feat=array_splice($_POST['Features']['count'], 0, count($_POST['Features']['ingredient']));
                        else $feat=$_POST['Features']['count'];
                foreach($_POST['Ingredients']['title'] as $key=>$i) {
                    $ing = new Ingredients;
                    $ing -> title=$i;
                    $ing->dimention=$_POST['Ingredients']['dimention'][$key];
                    if ($ing->save()) {
                        $feature = new Features;
                        $feature->item=$id;
                        $feature->ingredient=$ing->id;
                        $feature->count=$feat[$key];
                        if ($feature->save()) {}
                    }
                }
               
                    
            }
            if(isset($_POST['Features'])) {
                if (isset($_POST['Features']['ingredient'])) {
                    $feat=$_POST['Features']['ingredient'];
                    $featcount=$_POST['Features']['count'];
                    $featid=$_POST['Features']['id'];
                    foreach ($feat as $key=>$f) {
                        $feature=Features::findOne($featid[$key]);
                        if(is_null($feature)) {
                            $feature=new Features;
                            $feature->item=$id;
                        }
                        $feature->ingredient=$feat[$key];
                        $feature->count=$featcount[$key];
                        $feature->save();
                    }
                }
            }
			if ($model->save()) {
               return $this->redirect('/basic/web/products/'.$id);
           }
            
        }
        else
        return $this->render('update', ['model'=>$model]);
    }
    public function actionCreate() {
        if (Yii::$app->request->isPost) {
            $model=new Items;
            if(isset($_POST['Items'])) {
                $model->title='Новый товар';
                $model->save(); 
                
                $model->attributes=$_POST['Items'];
                echo json_encode($_POST);
                exit;
                if($_FILES['Items']['error']['img']==0) {
                    $model->imageFile = UploadedFile::getInstance($model, 'img');
                    $a=$model->upload();
                    if(gettype($a)=='string') $model->img=$a;
                }
                else unset($model->img);
                $model->update();
            }
                #die(json_encode($_POST));
            if (isset($_POST['Ingredients'])) {
                if(isset($_POST['Features']['ingredient']))
                $feat=array_splice($_POST['Features']['count'], 0, count($_POST['Features']['ingredient']));
                else $feat=$_POST['Features']['count'];
                foreach($_POST['Ingredients']['title'] as $key=>$i) {
                    $ing = new Ingredients;
                    $ing -> title=$i;
                    $ing->dimention=$_POST['Ingredients']['dimention'][$key];
                    if ($ing->save()) {
                        $feature = new Features;
                        $feature->item=$model->id;
                        $feature->ingredient=$ing->id;
                        $feature->count=$feat[$key];
                        if ($feature->save()) {}
                    }
                }
            }
            if(isset($_POST['Features'])) {
                if (isset($_POST['Features']['ingredient'])) {
                    $feat=$_POST['Features']['ingredient'];
                    $featcount=$_POST['Features']['count'];
                    foreach ($feat as $key=>$f) {
                        $feature=new Features;
                        $feature->item=$model->id;
                        $feature->ingredient=$feat[$key];
                        $feature->count=$featcount[$key];
                        $feature->save();
                    }
                }
            }
               return $this->redirect('/basic/web/products/'.$model->id);
            
        }
        else

        return $this->render('create');
    }
    
    public function actionDelete($id) {
        if (Yii::$app->request->isPost)
        return Items::findOne($id)->delete();
        Features::deleteAll('item='.$id);
    }
    public function actionSearch() {
        if (Yii::$app->request->isPost) {
            if (strlen($_POST['query']) > 3) {
                $arr = Items::find()->where(['like', 'title', $_POST['query']])->orderBy('title')->limit(5)->all();
                $res=[];
                if (!is_null($arr)) {
                    foreach($arr as $a) {
                        $res[]=['id'=>$a->id, 'title'=>$a->title];
                    }
                }
                return json_encode($res, JSON_UNESCAPED_UNICODE);
            }
        }
        else {
            #$models=Items::findAll('title LIKE '.$_GET['query']);
            $models=Items::find()->where(['like', 'title', $_GET['query']])->orderBy('title');
        $pages=new Pagination(['totalCount'=>$models->count(), 'pageSize'=>'10']);
        $models=$models->offset($pages->offset)->limit($pages->limit)->all();
            
            return $this->render('index', ['items'=>$models, 'pages'=>$pages]);
            
        }
    }
}
