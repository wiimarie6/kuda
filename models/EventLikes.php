<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event_likes".
 *
 * @property int $id
 * @property int $userId
 * @property int $eventId
 *
 * @property Event $event
 * @property User $user
 */
class EventLikes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_likes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'eventId'], 'required'],
            [['userId', 'eventId'], 'integer'],
            [['eventId'], 'exist', 'skipOnError' => true, 'targetClass' => Event::class, 'targetAttribute' => ['eventId' => 'id']],
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
            'userId' => 'User ID',
            'eventId' => 'Event ID',
        ];
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::class, ['id' => 'eventId']);
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

    public static function getIsLiked($id)
    {
        return self::find()->where(['eventId' => $id])->andWhere(['userId'=> Yii::$app->user->id])->one();
    }

}
