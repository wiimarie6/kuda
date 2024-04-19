<?php

namespace app\models;

use Yii;
use yii\bootstrap5\Html;
use yii\db\Query;

/**
 * This is the model class for table "genre".
 *
 * @property int $id
 * @property string $title
 *
 * @property Event[] $events
 */
class Genre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'genre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Жанр',
        ];
    }

    /**
     * Gets query for [[Events]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::class, ['genreId' => 'id']);
    }

    public static function getGenres() 
    {
        return (new Query())->select('title')->from('genre')->indexBy('id')->column();
    }

    public static function getGenreById($id) 
    {
        return Html::encode(self::findOne(['id' => $id])->title);
    }
}
