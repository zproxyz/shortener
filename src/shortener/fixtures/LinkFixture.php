<?php
namespace shortener\fixtures;

use shortener\models\Link;
use yii\test\ActiveFixture;

class LinkFixture extends ActiveFixture
{
    public $modelClass = Link::class;
    public $depends = [UserFixture::class];
}
