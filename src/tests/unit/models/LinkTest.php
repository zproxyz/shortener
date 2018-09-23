<?php

namespace tests\models;

use shortener\fixtures\LinkFixture;
use shortener\fixtures\LinkStatFixture;
use shortener\fixtures\UserFixture;
use shortener\forms\CreateUrlForm;
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
            'link_stat' => [
                'class' => LinkStatFixture::class,
                'dataFile' => codecept_data_dir() . 'link_stat.php',
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
        $link = Link::create($form->url, \Yii::$app->security->generateRandomString(12), $form->expiration);
        $this->assertEquals('https://test.dev/', $link->url);
    }

    public function testLinkisActive()
    {
        $link = Link::findOne(1);
        $this->assertTrue($link->isActive());
    }

    public function testLinkUpdateCounter()
    {
        $link = Link::findOne(1);
        $link->updateCounter();
        $this->assertEquals($link->counter, 1);
    }

    public function testVisitUrl()
    {
        $link = Link::findOne(1);
        $ip = '172.20.0.1';
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:62.0) Gecko/20100101 Firefox/62.0';
        $this->shortenerService->visitUrl($link,$ip,$userAgent);
        $this->assertEquals($link->counter, 1);
        $this->assertEquals(\count($link->linkStats),2);
    }

}
