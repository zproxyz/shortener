<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%link}}".
 *
 * @property int $id
 * @property string $url
 * @property string $hash
 * @property int $counter
 * @property string $expiration
 * @property string $created Дата создания
 * @property int $created_by Создавший пользователь
 *
 * @property User $user
 * @property LinkStat[] $linkStats
 */
class Link extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%link}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class'                 => BlameableBehavior::class,
                'createdByAttribute'    => 'created_by',
                'updatedByAttribute'    => null,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'hash', 'created', 'created_by'], 'required'],
            [['counter', 'created_by'], 'integer'],
            [['expiration', 'created'], 'safe'],
            [['url', 'hash'], 'string', 'max' => 255],
            [['hash'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'hash' => 'Hash',
            'counter' => 'Counter',
            'expiration' => 'Expiration',
            'created' => 'Дата создания',
            'created_by' => 'Создавший пользователь',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinkStats()
    {
        return $this->hasMany(LinkStat::className(), ['link_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return LinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LinkQuery(get_called_class());
    }
}
