<?php

namespace shortener\readModels;

use shortener\models\Link;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class LinkStatsReadRepository
{
    public function getAll(Link $link): DataProviderInterface
    {
        $query = $link->getLinkStats();
        return $this->_getProvider($query);
    }

    private function _getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }
}
