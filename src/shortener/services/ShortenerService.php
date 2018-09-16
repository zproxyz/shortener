<?php
/**
 * Created by PhpStorm.
 * User: Snow
 * Date: 16.09.2018
 * Time: 14:23
 */

namespace shortener\services;

use shortener\repositories\LinkRepository;
use shortener\repositories\LinkStatRepository;

class ShortenerService
{
    private $links;
    private $linkStats;

    public function __construct(LinkRepository $links, LinkStatRepository $linkStats)
    {
        $this->links = $links;
        $this->linkStats = $linkStats;
    }

    public function createShortUrl($url){

    }

    public function visitUrl($hash){

    }

    public function deleteUrl($id)
    {

    }

    public function updateExpirationTimeUrl($id,$expirationTime)
    {

    }
}
