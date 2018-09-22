<?php
/**
 * Created by PhpStorm.
 * User: Snow
 * Date: 16.09.2018
 * Time: 14:23
 */

namespace shortener\services;

use lysenkobv\GeoIP\GeoIP;
use shortener\forms\CreateUrlForm;
use shortener\models\Link;
use shortener\models\LinkStat;
use shortener\repositories\LinkRepository;
use shortener\repositories\LinkStatRepository;
use UAParser\Parser;

class ShortenerService
{
    private $links;
    private $linkStats;
    private $transcactionManager;
    private $geoIP;
    private $userAgentParser;

    public function __construct(
        LinkRepository $links,
        LinkStatRepository $linkStats,
        TransactionManager $transcactionManager,
        GeoIP $geoIP,
        Parser $userAgentParser
    ) {
        $this->links = $links;
        $this->linkStats = $linkStats;
        $this->transcactionManager = $transcactionManager;
        $this->geoIP = $geoIP;
        $this->userAgentParser = $userAgentParser;
    }

    /**
     * @param CreateUrlForm $form
     *
     * @throws \yii\base\Exception
     */
    public function createShortUrl(CreateUrlForm $form): void
    {
        $link = Link::create($form->url, $this->_generateHash(), $form->expiration);
        $this->links->save($link);
    }

    /**
     * @param Link $link
     * @param      $ip
     * @param      $userAgent
     *
     * @throws \Exception
     */
    public function visitUrl(Link $link, $ip, $userAgent): void
    {
        if (!$link->isActive()) {
            throw new \DomainException('Url is expired');
        }


        $geoInfo = $this->geoIP->ip($ip);
        $userAgentInfo = $this->userAgentParser->parse($userAgent);

        $link->updateCounter();
        $linkStat = LinkStat::create($link->id, $ip, $geoInfo, $userAgentInfo);

        $this->transcactionManager->wrap(function () use ($link, $linkStat) {
            $this->links->save($link);
            $this->linkStats->save($linkStat);
        });
    }

    /**
     * @param Link $link
     *
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function deleteUrl(Link $link)
    {
        $this->links->remove($link);
    }

    /**
     * @param Link $link
     *
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function updateExpirationTimeUrl(Link $link): bool
    {
        $link->expiration = $link->expiration ? \Yii::$app->formatter->asDatetime(strtotime($link->expiration),
            'Y-MM-dd H:m') : null;
        $this->links->save($link);
        return true;
    }

    /**
     *
     * @return string
     * @throws \yii\base\Exception
     */
    private function _generateHash(): string
    {
        return \Yii::$app->security->generateRandomString(12);
    }
}
