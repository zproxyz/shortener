<?php

namespace app\bootstrap;

use UAParser\Parser;
use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->set(Parser::class, function () {
            return Parser::create();
        });
    }
}
