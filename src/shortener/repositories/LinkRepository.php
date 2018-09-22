<?php
/**
 * Created by PhpStorm.
 * User: Snow
 * Date: 16.09.2018
 * Time: 14:23
 */

namespace shortener\repositories;


use shortener\models\Link;

class LinkRepository
{
    public function get($id, $isAdmin = false): Link
    {
        $searchFields = $isAdmin ? ['id' => $id] : ['id' => $id, 'created_by' => \Yii::$app->user->id];
        if (!$link = Link::findOne($searchFields)) {
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
