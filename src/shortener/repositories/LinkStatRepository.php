<?php
/**
 * Created by PhpStorm.
 * User: Snow
 * Date: 16.09.2018
 * Time: 14:23
 */

namespace shortener\repositories;

use app\models\LinkStat;

class LinkStatRepository
{
    public function get($id): LinkStat
    {
        if (!$linkStat = LinkStat::findOne($id)) {
            throw new NotFoundException('LinkStat is not found.');
        }
        return $linkStat;
    }


    public function save(LinkStat $linkStat): void
    {
        if (!$linkStat->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param LinkStat $linkStat
     *
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(LinkStat $linkStat): void
    {
        if (!$linkStat->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
