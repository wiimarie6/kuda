<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "genre_user".
 *
 * @property int $id
 * @property int $genreId
 * @property int $userId
 *
 * @property Genre $genre
 * @property User $user
 */
class GenreUser extends \yii\db\ActiveRecord
{
    public $selectedGenres;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'genre_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['selectedGenres'], 'required'],
            [['genreId', 'userId'], 'integer'],
            ['selectedGenres', 'each', 'rule' => 
                [ 'exist', 'skipOnError' => true, 'targetClass' => Genre::class, 'targetAttribute' => [
                'selectedGenres'=> 'id',
                        ],
                ],
            ],
            [['genreId'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::class, 'targetAttribute' => ['genreId' => 'id']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'genreId' => 'Genre ID',
            'userId' => 'User ID',
        ];
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'userId']);
    }

    public static function getGenresByUser()
    {
        return self::find()->select(['title'])->leftJoin('genre', 'genre_user.genreId = genre.id')->where(["genre_user.userId" => Yii::$app->user->id])->asArray()->column();
    }
}
