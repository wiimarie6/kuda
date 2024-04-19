<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event_user".
 *
 * @property int $id
 * @property int $eventId
 * @property int $userId
 *
 * @property Event $event
 * @property User $user
 */
class EventUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['eventId', 'userId'], 'required'],
            [['eventId', 'userId'], 'integer'],
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
            'eventId' => 'Event ID',
            'userId' => 'User ID',
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
}
