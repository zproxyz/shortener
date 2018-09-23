<?php

namespace tests\models;

use shortener\fixtures\UserFixture;
use shortener\forms\LoginForm;

class LoginFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    public function testLoginNoUser()
    {
        $model = new LoginForm([
            'username' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        expect_not($model->login());
        expect_that(\Yii::$app->user->isGuest);
    }

    public function testLoginWrongPassword()
    {
        $model = new LoginForm([
            'username' => 'test',
            'password' => 'wrong_password',
        ]);

        expect_not($model->login());
        expect_that(\Yii::$app->user->isGuest);
        expect($model->errors)->hasKey('password');
    }

    public function testLoginCorrect()
    {
        $model = new LoginForm([
            'username' => 'test',
            'password' => 'test',
        ]);

        expect_that($model->login());
        expect_not(\Yii::$app->user->isGuest);
        expect($model->errors)->hasntKey('password');
    }

}
