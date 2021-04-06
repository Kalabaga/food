<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Ingredients extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%ingredients}}';
    }

    public function rules()
    {
        return [
            [['title', 'dimention'], 'required'],
            ['dimention', 'default', 'value'=>'г']
        ];
    }
    public function attributeLabel() {
        return [
            'title' => 'Название ингредиента',
            'dimention' => 'Единица измерения',
            'dim' => 'Ед. изм.',
            'desc' => 'Примечание'
        ];
    }
}
