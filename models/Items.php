<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\Request;
use yii\db\Query;
use yii\db\ActiveRecord;
use yii\data\Pagination;
use yii\web\UploadedFile;

class Items extends ActiveRecord
{
    public $imageFile;
    
    public static function tableName()
    {
        return '{{%items}}';
    }
    public function rules()
    {
        return [
            // username and password are both required
            [['title'], 'required'],
            // rememberMe must be a boolean value
            [['type'], 'integer'],
            [['title', 'desc'], 'string'],
            [['img'], 'file', 'extensions'=>'jpg, jpeg, png']
        ];
    }
    public function attributeLabels() {
        return [
            'title' => 'Название товара',
            'type' => 'Тип',
            'ingredients' => 'Ингредиенты',
            'desc' => 'Примечание'
        ];
    }
    public static function all() {
        #return Yii::$app->db->createCommand('SELECT * FROM y_items')->queryAll();
        
        return (new Query)->from('y_items');
    }
    public function model($id) {
        if(is_null($id)) return 'Некоректный запрос';
        elseif (is_numeric($id)) return Yii::$app->db->createCommand('SELECT * FROM y_items WHERE id='.$id);
        else return 'Некоректный запрос';
    }
    public function upload() {
        if ($this->validate()) {
            $file=$this->imageFile;
            $fileName='img/'.$this->id.'_'.md5($file->baseName.time()).'.'.$file->extension;
            $file->saveAs($fileName);
            return $fileName;
        }
        else return false;
    }
    public static function types() {
        $array = Yii::$app->db->createCommand('SELECT id, title FROM y_types ORDER BY title')->query();
        $arr=[];
        foreach($array as $a) {
            $arr[$a['id']]=$a['title'];
        }
        return $arr;
        #return (new Query)->select('title')->from('y_types')->queryColumn();
    }
}
