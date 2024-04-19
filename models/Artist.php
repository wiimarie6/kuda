<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "artist".
 *
 * @property int $id
 * @property string $name
 */
class Artist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'artist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public static function getArtistsByEventId($id)
    {
        return (new Query())->select('name')->from('event_artist')->leftJoin('artist', 'event_artist.artist_id=artist.id')->where(['event_artist.event_id' => $id])->all();
    }

}
