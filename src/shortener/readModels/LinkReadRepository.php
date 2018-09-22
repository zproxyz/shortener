<?php

namespace shortener\readModels;

use shortener\models\Link;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class LinkReadRepository
{
    public function getAll($isAdmin = false): DataProviderInterface
    {
        $searchFields = $isAdmin ? [] : ['created_by' => \Yii::$app->user->id];
        $query = Link::find()->andWhere($searchFields);
        return $this->_getProvider($query);
    }

    public function find($id, $isAdmin = false): ?Link
    {
        $searchFields = $isAdmin ? ['id' => $id] : ['created_by' => \Yii::$app->user->id, 'id' => $id];
        return Link::find()->andWhere($searchFields)->one();
    }


    public function getByHash(string $hash): Link
    {
        return Link::findOne(['hash' => $hash]);
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
