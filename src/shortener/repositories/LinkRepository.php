<?php
/**
 * Created by PhpStorm.
 * User: Snow
 * Date: 16.09.2018
 * Time: 14:23
 */

namespace shortener\repositories;

use app\models\Link;
use app\models\LinkStat;

class LinkRepository
{
    public function get($id): Link
    {
        if (!$link = Link::findOne($id)) {
            throw new NotFoundException('Link is not found.');
        }
        return $link;
    }


    public function save(Link $link): void
    {
        if (!$link->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param Link $link
     *
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Link $link): void
    {
        if (!$link->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
