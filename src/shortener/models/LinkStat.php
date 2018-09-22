<?php

namespace shortener\models;

use lysenkobv\GeoIP\Result;
use UAParser\Result\Client;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%link_stat}}".
 *
 * @property int    $id
 * @property int    $link_id
 * @property string $datetime
 * @property string $ip
 * @property string $country
 * @property string $city
 * @property string $user_agent
 * @property string $os
 * @property string $os_version
 * @property string $browser
 * @property string $browser_version
 *
 * @property Link   $link
 */
class LinkStat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%link_stat}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => function () {
                    return date('Y-m-d H:i:s');
                },
                'createdAtAttribute' => 'datetime',
                'updatedAtAttribute' => null,
            ],
        ];
    }

    public static function create($linkId, $ip, Result $geoData, Client $userAgentData)
    {
        $linkStats = new static();

        $linkStats->link_id = $linkId;

        $linkStats->ip = $ip;
        $linkStats->country = $geoData->country;
        $linkStats->city = $geoData->city;

        $linkStats->user_agent = $userAgentData->originalUserAgent;
        $linkStats->browser = $userAgentData->ua->family;
        $linkStats->browser_version = $userAgentData->ua->toVersion();
        $linkStats->os = $userAgentData->os->family;
        $linkStats->os_version = $userAgentData->os->toVersion();

        return $linkStats;
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['link_id', 'ip', 'user_agent'], 'required'],
            [['link_id'], 'integer'],
            [['datetime'], 'safe'],
            [['ip'], 'string', 'max' => 11],
            [
                ['country', 'city', 'user_agent', 'os', 'os_version', 'browser', 'browser_version'],
                'string',
                'max' => 255,
            ],
            [
                ['link_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Link::className(),
                'targetAttribute' => ['link_id' => 'id'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link_id' => 'Link ID',
            'datetime' => 'Datetime',
            'ip' => 'Ip',
            'country' => 'Country',
            'city' => 'City',
            'user_agent' => 'User Agent',
            'os' => 'Os',
            'os_version' => 'Os Version',
            'browser' => 'Browser',
            'browser_version' => 'Browser Version',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLink()
    {
        return $this->hasOne(Link::className(), ['id' => 'link_id']);
    }

    /**
     * {@inheritdoc}
     * @return LinkStatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LinkStatQuery(get_called_class());
    }
}
