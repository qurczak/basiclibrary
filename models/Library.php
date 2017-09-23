<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Library
 * @package app\models
 * @property string $name
 * @property string $date
 */
class Library extends ActiveRecord
{

    public static function tableName()
    {
        return 'library';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'min' => 1, 'max' => 64],
        ];
    }

    /**
     * Fill up date if is empty, only when we create record
     *
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($this->date == "") {
            $this->date = date("Y-m-d G:i:s");
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}