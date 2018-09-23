<?php

namespace tests\models;

use shortener\fixtures\LinkFixture;
use shortener\fixtures\UserFixture;
use shortener\forms\CreateUrlForm;
use shortener\forms\LoginForm;
use shortener\models\Link;
use shortener\services\ShortenerService;

class LinkTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    /** @var ShortenerService $shortenerService */
    protected $shortenerService;

    protected function _before()
    {
        $this->shortenerService = \Yii::createObject(ShortenerService::class);
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
            'link' => [
                'class' => LinkFixture::class,
                'dataFile' => codecept_data_dir() . 'link.php',
            ],
        ]);
    }

    protected function _after()
    {
        \Yii::$app->user->logout();
    }


    // tests
    public function testLinkCreate()
    {
        $form = new CreateUrlForm(['url' => 'https://test.dev/']);
        $link = Link::create($form->url,\Yii::$app->security->generateRandomString(12),$form->expiration);
        $this->assertEquals('https://test.dev/',$link->url);
    }
}
