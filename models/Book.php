<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Book
 * @package app\models
 * @property string $library_id
 * @property string $category_id
 * @property string $name
 * @property string $ISBN
 * @property string $title
 * @property string $author
 * @property string $date
 */
class Book extends ActiveRecord
{

    public static function tableName()
    {
        return 'book';
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
            ['name', 'string', 'min' => 1, 'max' => 128],
            ['library_id', 'required'],
            ['library_id', 'integer'],
            ['category_id', 'required'],
            ['category_id', 'integer'],
            ['ISBN', 'required'],
            ['ISBN', 'string', 'min' => 1, 'max' => 64],
            ['title', 'required'],
            ['title', 'string', 'min' => 1, 'max' => 128],
            ['author', 'required'],
            ['author', 'string', 'min' => 1, 'max' => 64],
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
        return parent::beforeSave($insert);
    }
}
