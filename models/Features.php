<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Features extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%features}}';
    }

    public function rules()
    {
        return [];
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
