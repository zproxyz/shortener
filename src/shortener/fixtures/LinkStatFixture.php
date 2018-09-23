<?php
namespace shortener\fixtures;

use shortener\models\Link;
use shortener\models\LinkStat;
use yii\test\ActiveFixture;

class LinkStatFixture extends ActiveFixture
{
    public $modelClass = LinkStat::class;
    public $depends = [LinkFixture::class];
}
