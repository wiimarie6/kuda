<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $date
 * @property int $userId
 * @property int $genreId
 * @property string $location
 * @property string $image
 * @property string $createdAt
 * @property string $price
 *
 * @property EventArtist[] $eventArtists
 * @property EventLikes[] $eventLikes
 * @property EventUser[] $eventUsers
 * @property Genre $genre
 */
class Event extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $artists;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'date', 'artists', 'genreId', 'location', 'price'], 'required'],
            [['date', 'createdAt'], 'safe'],
            [['date'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['genreId', 'userId'], 'integer'],
            [['title', 'location', 'image', 'price', 'originalLink'], 'string', 'max' => 255],
            ['originalLink', 'url'],
            ['description', 'string'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'id']],
            [['genreId'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::class, 'targetAttribute' => ['genreId' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            ['price', 'match', 'pattern' => "/^\d+$/", 'message' => 'В наименовании цены могут быть только цифры'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Содержание',
            'date' => 'Дата проведения',
            'artists' => 'Артисты',
            'genreId' => 'Жанр',
            'location' => 'Место проведения',
            'image' => 'Афиша',
            'createdAt' => 'Временная метка',
            'price' => 'Цена от (р)',
            'imageFile' => 'Прикрепите афишу',
            'originalLink' => 'Ссылка на мероприятие',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $fileName = Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs('uploads/' . $fileName);
            $this->imageFile->name = $fileName;
            return true;
        } else {
            return false;
        }
    }

    public function beforeSave($insert)
{
    if (!parent::beforeSave($insert)) {
        return false;
    }

    if ($insert) {
        
        $this->image = $this->imageFile->name;
        $this->userId = Yii::$app->user->id;
    }
    return true;
}

    /**
     * Gets query for [[EventArtists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventArtists()
    {
        return $this->hasMany(EventArtist::class, ['event_id' => 'id']);
    }

    /**
     * Gets query for [[EventLikes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventLikes()
    {
        return $this->hasMany(EventLikes::class, ['eventId' => 'id']);
    }

    /**
     * Gets query for [[EventUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventUsers()
    {
        return $this->hasMany(EventUser::class, ['eventId' => 'id']);
    }

    /**
     * Gets query for [[Genre]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::class, ['id' => 'genreId']);
    }

}
